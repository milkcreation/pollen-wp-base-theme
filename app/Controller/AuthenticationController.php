<?php declare(strict_types=1);

namespace App\Controller;

use App\AppAwareTrait;
use App\Form\Authentication\Signin as SigninForm;
use tiFy\Contracts\Form\FactoryField;
use tiFy\Contracts\Http\Response;
use tiFy\Support\Proxy\Form;
use tiFy\Support\Proxy\Request;
use tiFy\Support\Proxy\Url;
use tiFy\Validation\Validator as v;
use tiFy\Routing\BaseController;
use WP_Error;

class AuthenticationController extends BaseController
{
    use AppAwareTrait;

    /**
     * Déconnection.
     *
     * @return Response
     */
    public function logout(): Response
    {
        wp_logout();

        return $this->redirect('/');
    }

    /**
     * Formulaire d'authentification.
     *
     * @return Response
     */
    public function signin(): Response
    {
        $this->share('navbar', false);

        /** @var SigninForm $form */
        $form = Form::get('auth.signin')->prepare();

        if (Request::isMethod('POST')) {
            $this->validateSignin($form);

            if ($form->isSuccessed()) {
                return $form->handle()->redirect();
            }
        }

        // Mise en file des scripts
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_script('app.authentication');
            wp_enqueue_style('app.authentication');
        });

        // Meta Balise
        $this->app()->config()->metaTags([
            'title' => __('Authentification', 'theme'),
        ]);

        // Classes de la balise body
        add_filter('body_class', function ($classes) {
            $classes[] = 'Body--authentication';

            return $classes;
        });

        $this->set([
            'article-header' => [
                'title' => __('Authentification', 'theme'),
            ],
            'content'        => $form,
        ]);

        return $this->view('app::authentication', $this->all());
    }

    /**
     * Validation du formulaire d'authentification.
     *
     * @param SigninForm $form
     *
     * @return void
     */
    public function validateSignin(SigninForm $form): void
    {
        if (!$form->handle()->verify()) {
            $form->error(__('Une erreur est survenue, impossible de valider votre demande d\'authentification.',
                'theme'));
        } else {
            $form->handle()->prepare();

            /** @var FactoryField[] $fields */
            $fields = $form->fields()->all();

            if (!v::notEmpty()->validate($form->handle()->get('email'))) {
                $fields['email']->addError(__('Le champ "E-mail" doit être renseigné.', 'theme'));
            }

            if (!v::notEmpty()->validate($form->handle()->get('password'))) {
                $fields['password']->addError(__('Le champ "Mot de passe" doit être renseigné.', 'theme'));
            }

            if (!$form->hasError()) {
                $secure_cookie = '';
                if (($log = Request::input('log', false)) && !force_ssl_admin()) {
                    $user_name = sanitize_user($log);
                    if ($user = get_user_by('login', $user_name)) {
                        if (get_user_option('use_ssl', $user->ID)) {
                            $secure_cookie = true;
                            force_ssl_admin(true);
                        }
                    }
                }

                $reauth = !Request::input('reauth') ? false : true;
                $user = wp_signon([
                    'user_login'    => $form->handle()->get('email'),
                    'user_password' => $form->handle()->get('password'),
                    'remember'      => $form->handle()->get('remember'),
                ], $secure_cookie);

                if (!Request::cookie(LOGGED_IN_COOKIE)) {
                    if (headers_sent()) {
                        $user = new WP_Error(
                            'test_cookie',
                            __('Désolé, impossible d\'enregistrer les cookies d\'authentification.', 'theme')
                        );
                    } elseif (Request::cookie('testcookie') && !Request::cookie(TEST_COOKIE)) {
                        $user = new WP_Error(
                            'test_cookie',
                            __(
                                'Il semble que les cookies soit bloqués par votre navigateur. ' .
                                'Impossible de procéder à l\'authentification.',
                                'theme'
                            )
                        );
                    }
                }

                if (!$user instanceof WP_Error && !$reauth) {
                    $form->handle()->setRedirectUrl(Url::root()->render());
                    $form->handle()->success();
                } elseif ($user instanceof WP_Error) {
                    if ($message = $user->get_error_message()) {
                        $form->notices()->add('error', $message);
                    } else {
                        $form->notices()->add('error', __('Erreur lors de la tentative d\'authentification', 'theme'));
                    }

                    $form->handle()->fail();
                }
            } else {
                $form->handle()->fail();
            }
        }
    }
}