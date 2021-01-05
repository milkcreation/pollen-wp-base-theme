<?php

declare(strict_types=1);

namespace App\Form;

use App\AppAwareTrait;
use tiFy\Form\FormFactory as BaseFormFactory;

class Signin extends BaseFormFactory
{
    use AppAwareTrait;

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->set([
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
                    'title'    => __('Email', 'theme'),
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
    }
}
