<?php

declare(strict_types=1);

namespace App\Form;

use App\AppAwareTrait;
use tiFy\Contracts\Form\FormFactory as FormFactoryContract;
use tiFy\Form\BaseFormFactory;
use tiFy\Support\Proxy\Partial;

class ContactForm extends BaseFormFactory
{
    use AppAwareTrait;

    /**
     * @inheritDoc
     */
    public function boot(): FormFactoryContract
    {
        $this->params([
            'addons'  => [
                'mailer',
                'record',
            ],
            'attrs'   => [
                'class' => '%s Form--contact',
            ],
            'buttons' => [
                'submit' => false,
            ],
            'fields'  => [
                'firstname'    => [
                    'attrs'    => [
                        'placeholder' => __('Renseignez votre prénom', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Prénom', 'theme'),
                    'type'     => 'text',
                ],
                'lastname'     => [
                    'attrs'    => [
                        'placeholder' => __('Renseignez votre nom', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Nom', 'theme'),
                    'type'     => 'text',
                ],
                'company_name' => [
                    'attrs' => [
                        'placeholder' => __('Renseignez le nom de votre société', 'theme'),
                    ],
                    'title' => __('Société', 'theme'),
                    'type'  => 'text',
                ],
                'address1'     => [
                    'attrs' => [
                        'placeholder' => __('Renseignez votre adresse postale', 'theme'),
                    ],
                    'title' => __('Adresse postale', 'theme'),
                    'type'  => 'text',
                ],
                'address2'     => [
                    'attrs' => [
                        'placeholder' => __('Indiquez votre complément d\'adresse', 'theme'),
                    ],
                    'title' => __('Complément d\'adresse', 'theme'),
                    'type'  => 'text',
                ],
                'city'         => [
                    'attrs'    => [
                        'placeholder' => __('Renseignez votre ville', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Ville', 'theme'),
                    'type'     => 'text',
                    'wrapper'  => [
                        'attrs' => [
                            'class' => '%s FormField--w50',
                        ],
                    ],
                ],
                'postcode'     => [
                    'attrs'    => [
                        'placeholder' => __('Renseignez votre code postal', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Code postal', 'theme'),
                    'type'     => 'text',
                    'wrapper'  => [
                        'attrs' => [
                            'class' => '%s FormField--w50',
                        ],
                    ],
                ],
                'email'        => [
                    'attrs'       => [
                        'placeholder' => __('Renseignez votre adresse de messagerie', 'theme'),
                    ],
                    'required'    => true,
                    'title'       => __('Adresse de messagerie', 'theme'),
                    'type'        => 'text',
                    'validations' => ['email'],
                    'wrapper'     => [
                        'attrs' => [
                            'class' => '%s FormField--w50',
                        ],
                    ],
                ],
                'phone'        => [
                    'attrs'    => [
                        'placeholder' => __('Renseignez votre numéro de téléphone', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Téléphone', 'theme'),
                    'type'     => 'text',
                    'wrapper'  => [
                        'attrs' => [
                            'class' => '%s FormField--w50',
                        ],
                    ],
                ],
                'subject' => [
                    'attrs'    => [
                        'placeholder' => __('Renseignez l\'objet de votre message', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Objet du message', 'theme'),
                    'type'     => 'text',
                ],
                'message' => [
                    'attrs'    => [
                        'placeholder' => __('Précisez l\'objet de votre message', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Message', 'theme'),
                    'type'     => 'textarea',
                ],
                'privacy' => [
                    'addons'    => [
                        'mailer' => [
                            'show' => false,
                        ],
                        'record' => [
                            'column'  => false,
                            'preview' => false,
                            'save'    => false,
                        ],
                    ],
                    'label'     => [
                        'content'  => sprintf(
                            __('J\'accepte les %s du site', 'theme'), Partial::get('privacy-link')->render()
                        ),
                        'position' => 'after',
                    ],
                    'required'  => true,
                    'title'     => __('Politique de confidentialité', 'theme'),
                    'transport' => false,
                    'type'      => 'checkbox',
                ],
                'submit'  => [
                    'addons'  => [
                        'mailer' => [
                            'show' => false,
                        ],
                        'record' => [
                            'column'  => false,
                            'preview' => false,
                            'save'    => false,
                        ],
                    ],
                    'attrs'   => [
                        'class' => '%s Button--2',
                    ],
                    'extras'  => [
                        'type' => 'submit',
                    ],
                    'type'    => 'button'
                ],
            ],
            'labels'  => [
                'gender'   => true,
                'plural'   => __('demandes de contact', 'theme'),
                'singular' => __('demande de contact', 'theme'),
            ],
            'title'   => __('Demandes de contact', 'theme'),
        ]);
        return parent::boot();
    }
}