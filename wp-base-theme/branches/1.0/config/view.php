<?php

use App\View;

return [
    // Moteur.
    'engine'  => 'plates',

    // Générateur.
    'factory' => View::class,

    // Déclaration des répertoires des vues.
    'folders' => [
        'admin'   => get_template_directory() . '/views/admin',
        'app'     => get_template_directory() . '/views/app',
        'layout'  => get_template_directory() . '/views/layout',
        'partial' => get_template_directory() . '/views/partial',
    ],
];