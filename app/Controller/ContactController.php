<?php

declare(strict_types=1);

namespace App\Controller;

use App\AppAwareTrait;
use App\Form\ContactForm;
use tiFy\Contracts\Form\FieldDriver;
use tiFy\Contracts\Http\Response;
use tiFy\Form\FieldValidateException;
use tiFy\Partial\Drivers\BreadcrumbDriverInterface;
use tiFy\Routing\BaseController;
use tiFy\Support\Proxy\Form;
use tiFy\Support\Proxy\Partial;
use tiFy\Support\Proxy\Url;
use tiFy\Wordpress\Proxy\PageHook;

class ContactController extends BaseController
{
    use AppAwareTrait;

    public function boot(): void
    {
        parent::boot();
        events()->listen('wp-admin.form.boot', function () {
            Form::setForm('contact', (new ContactForm())->setApp($this->app()));
        });
    }

    /**
     * Affichage de la page du formulaire d'aide en ligne.
     *
     * @return Response
     */
    public function index(): Response
    {
        // Mise en file des scripts
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('app.contact');
            wp_enqueue_script('app.contact');
        });
        /** @var ContactForm $form */
        $form = Form::register('contact', (new ContactForm())->setApp($this->app()))->boot();
        if ($form->isSubmitted()) {
            $this->validate($form);
            if ($form->isSuccessed()) {
                return $form->handle()->redirect();
            }
        }

        if ($post = PageHook::get('contact')->post()) {
            $this->set('article-header', compact('post'));
        } else {
            /** @var BreadcrumbDriverInterface $breadcrumb */
            $breadcrumb = Partial::get('breadcrumb');
            $breadcrumb->main()->add([
                'content' => __('Accueil', 'theme'),
                'url'     => Url::root('/')->render(),
            ]);
            $breadcrumb->main()->add(__('Contactez-nous', 'theme'));

            $this->set('article-header', [
                'title'   => __('Contactez-nous', 'theme'),
            ]);
        }
        // Configuration.
        $this->set([
            'article-body' => [
                'content' => $form
            ]
        ]);
        return $this->view('app::contact', $this->all());
    }

    /**
     * Validation de formulaire
     *
     * @param ContactForm $form
     *
     * @return void
     */
    public function validate(ContactForm $form): void
    {
        /** @var FieldDriver[] $fields */
        $fields = $form->fields()->all();
        try {
            $fields['firstname']->validate();
        } catch (FieldValidateException $e) {
            $fields['firstname']->error(__('Veuillez renseigner votre prénom.', 'theme'));
        }
        try {
            $fields['lastname']->validate();
        } catch (FieldValidateException $e) {
            $fields['lastname']->error(__('Veuillez renseigner votre nom de famille.', 'theme'));
        }
        try {
            $fields['city']->validate();
        } catch (FieldValidateException $e) {
            $fields['city']->error(__('Veuillez renseigner votre ville.', 'theme'));
        }
        try {
            $fields['postcode']->validate();
        } catch (FieldValidateException $e) {
            $fields['postcode']->error(__('Veuillez renseigner votre code postal.', 'theme'));
        }
        try {
            $fields['email']->validate();
        } catch (FieldValidateException $e) {
            if ($e->isRequired()) {
                $fields['email']->error(__('Veuillez renseigner votre adresse de messagerie.', 'theme'));
            } else {
                $fields['email']->error(
                    __('L\'adresse de messagerie renseignée n\'est pas un e-mail valide.', 'theme')
                );
            }
        }
        try {
            $fields['phone']->validate();
        } catch (FieldValidateException $e) {
            $fields['phone']->error(__('Veuillez renseigner votre numéro de téléphone.', 'theme'));
        }
        try {
            $fields['subject']->validate();
        } catch (FieldValidateException $e) {
            $fields['subject']->error(__('Veuillez renseigner le sujet de votre demande.', 'theme'));
        }
        try {
            $fields['message']->validate();
        } catch (FieldValidateException $e) {
            $fields['message']->error(__('Veuillez préciser l\'objet de votre demande.', 'theme'));
        }
        try {
            $fields['privacy']->validate();
        } catch (FieldValidateException $e) {
            $fields['privacy']->error(
                __('Veuillez accepter les conditions relatives aux données personnelles.', 'theme')
            );
        }
        if (!$form->handle()->isValidated()) {
            $form->handle()->fail();
        } else {
            $form->handle()->success();
        }
    }
}