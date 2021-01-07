<?php

declare(strict_types=1);

namespace App\Form;

use App\AppAwareTrait;
use tiFy\Contracts\Form\FormFactory as FormFactoryContract;
use tiFy\Form\BaseFormFactory;

class SigninForm extends BaseFormFactory
{
    use AppAwareTrait;

    /**
     * @inheritDoc
     */
    public function boot(): FormFactoryContract
    {
        $this->params([
            'buttons'  => [
                'submit' => false
            ],
            'fields'  => [
                'email'         => [
                    'attrs'    => [
                        'autocomplete' => 'current-email',
                        'placeholder'  => __('Renseignez votre email', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Identifiant ou adresse e-mail', 'theme'),
                    'type'     => 'text',
                ],
                'password'      => [
                    'attrs'    => [
                        'autocomplete' => 'current-password',
                        'placeholder'  => __('Saisissez votre mot de passe', 'theme'),
                    ],
                    'required' => true,
                    'title'    => __('Mot de passe', 'theme'),
                    'type'     => 'password',
                ],
                'submit'        => [
                    'attrs'  => [
                        'class' => 'Button--1',
                    ],
                    'extras' => [
                        'content' => __('Accéder à votre espace', 'theme'),
                        'type'    => 'submit',
                    ],
                    'type'   => 'button',
                ],
            ]
        ]);
        return parent::boot();
    }
}
