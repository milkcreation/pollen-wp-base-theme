<?php

use tiFy\Asset\AssetServiceProvider;
use tiFy\Auth\AuthServiceProvider;
use tiFy\Cache\CacheServiceProvider;
use tiFy\Column\ColumnServiceProvider;
use tiFy\Console\ConsoleServiceProvider;
use tiFy\Cookie\CookieServiceProvider;
use tiFy\Cron\CronServiceProvider;
use tiFy\Database\DatabaseServiceProvider;
use tiFy\Debug\DebugServiceProvider;
use tiFy\Encryption\EncryptionServiceProvider;
use tiFy\Field\FieldServiceProvider;
use tiFy\Filesystem\FilesystemServiceProvider;
use tiFy\Form\FormServiceProvider;
use tiFy\Log\LogServiceProvider;
use tiFy\Mail\MailServiceProvider;
use tiFy\Metabox\MetaboxServiceProvider;
use tiFy\Partial\PartialServiceProvider;
use tiFy\PostType\PostTypeServiceProvider;
use tiFy\Routing\RoutingServiceProvider;
use tiFy\Session\SessionServiceProvider;
use tiFy\Taxonomy\TaxonomyServiceProvider;
use tiFy\Template\TemplateServiceProvider;
use tiFy\User\UserServiceProvider;
use tiFy\Validation\ValidationServiceProvider;
use tiFy\View\ViewServiceProvider;
use tiFy\Wordpress\WordpressServiceProvider;

return [
    // Liste des fournisseurs de service.
    'providers' => [
        /** Composants */
        AssetServiceProvider::class,
        AuthServiceProvider::class,
        CacheServiceProvider::class,
        ColumnServiceProvider::class,
        ConsoleServiceProvider::class,
        CookieServiceProvider::class,
        CronServiceProvider::class,
        DatabaseServiceProvider::class,
        DebugServiceProvider::class,
        EncryptionServiceProvider::class,
        FieldServiceProvider::class,
        FilesystemServiceProvider::class,
        FormServiceProvider::class,
        LogServiceProvider::class,
        MailServiceProvider::class,
        MetaboxServiceProvider::class,
        PartialServiceProvider::class,
        PostTypeServiceProvider::class,
        RoutingServiceProvider::class,
        SessionServiceProvider::class,
        TaxonomyServiceProvider::class,
        TemplateServiceProvider::class,
        UserServiceProvider::class,
        ValidationServiceProvider::class,
        ViewServiceProvider::class,
        WordpressServiceProvider::class,
        /**/

        /** Extensions */
        Pollen\CookieLaw\CookieLawServiceProvider::class,
        Pollen\OutdatedBrowser\OutdatedBrowser::class,
        Pollen\ThemeSuite\ThemeSuiteServiceProvider::class,
        Pollen\TinyMce\TinyMceServiceProvider::class,
        /**/

        /** Applicatifs */
        App\Filesystem\FilesystemServiceProvider::class,
        App\ServiceProvider::class,
        App\Form\FormServiceProvider::class,
        App\Metabox\MetaboxServiceProvider::class,
        App\Partial\PartialServiceProvider::class,
        App\Routing\RoutingServiceProvider::class,
        App\Wordpress\WordpressServiceProvider::class
        /**/
    ],

    /**
     * Paramètres de configuration de l'application.
     * @see \App\Params
     * @var array
     */
    'config'     => [
        // Identifiant Google Analytics
        'ua-code' => ''
    ]
];
