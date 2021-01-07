<?php

declare(strict_types=1);

namespace App\Controller;

use App\AppAwareTrait;
use App\Form\SigninForm;
use tiFy\Contracts\Form\FieldDriver;
use tiFy\Contracts\Http\Response;
use tiFy\Form\FieldValidateException;
use tiFy\Support\Proxy\Form;
use tiFy\Support\Proxy\Request;
use tiFy\Support\Proxy\Url;
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
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_script('app.authentication');
                wp_enqueue_style('app.authentication');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--authentication';

                return $classes;
            }
        );
        // Meta Balises.
        $this->app()->config()->metaTags(
            [
                'title'       => __('Authentification', 'theme'),
                'description' => __('Interface d\'authentification du site', 'theme'),
                'robots'      => 'none',
            ]
        );
        remove_all_actions('wpseo_head');
        /** @var SigninForm $form */
        $form = Form::register('signin', (new SigninForm())->setApp($this->app()))->boot();
        if ($form->isSubmitted()) {
            $this->validate($form);
            if ($form->isSuccessed()) {
                return $form->handle()->redirect();
            }
        }
        // Configuration.
        $this->set(
            [
                'article-header' => [
                    'title'      => __('Authentification', 'theme'),
                    'content'    => false,
                    'breadcrumb' => false,
                ],
                'article-body'   => [
                    'content' => $form,
                ],
                'navbar'         => false,
            ]
        );
        return $this->view('app::authentication', $this->all());
    }

    /**
     * Validation du formulaire d'authentification.
     *
     * @param SigninForm $form
     *
     * @return void
     */
    public function validate(SigninForm $form): void
    {
        /** @var FieldDriver[] $fields */
        $fields = $form->fields()->all();

        try {
            $fields['email']->validate();
        } catch (FieldValidateException $e) {
            $fields['email']->error(__('Le champ "E-mail" doit être renseigné.', 'theme'));
        }

        try {
            $fields['password']->validate();
        } catch (FieldValidateException $e) {
            $fields['password']->error(__('Le champ "Mot de passe" doit être renseigné.', 'theme'));
        }

        if (!$form->handle()->isValidated()) {
            $form->handle()->fail();
        } else {
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
            $user = wp_signon(
                [
                    'user_login'    => $fields['email']->getValue(),
                    'user_password' => $fields['password']->getValue(),
                    'remember'      => false,
                ],
                $secure_cookie
            );

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
                $form->handle()->setRedirectUrl(Url::root('/')->render());
                $form->handle()->success();
            } elseif ($user instanceof WP_Error) {
                if ($message = $user->get_error_message()) {
                    $form->error($message);
                } else {
                    $form->error(__('Erreur lors de la tentative d\'authentification', 'theme'));
                }
                $form->handle()->fail();
            }
        }
    }
}