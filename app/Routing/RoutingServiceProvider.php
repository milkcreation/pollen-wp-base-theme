<?php

declare(strict_types=1);

namespace App\Routing;

use App\App;
use App\Controller\AuthenticationController;
use App\Controller\ContactController;
use App\Controller\UtilsController;
use App\Controller\WordpressController;
use App\Middleware\LoggedInMiddleware;
use App\Middleware\LoggedOutMiddleware;
use tiFy\Container\ServiceProvider;
use tiFy\Support\Proxy\Partial;
use tiFy\Support\Proxy\Url;
use tiFy\Wordpress\Contracts\Routing\RouteGroup;
use tiFy\Wordpress\Proxy\Router;
use tiFy\Wordpress\Proxy\PageHook;

class RoutingServiceProvider extends ServiceProvider
{
    /**
     * Instance de l'application.
     * @var App
     */
    protected $app;

    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        $this->app = $this->getContainer()->get('app');

        add_action(
            'init',
            function () {
                /** CONTROLEURS */
                Router::setControllerStack(
                    [
                        'app.auth'      => (new AuthenticationController())->setApp($this->app),
                        'app.contact'   => (new ContactController())->setApp($this->app),
                        'app.utils'     => (new UtilsController())->setApp($this->app),
                        'app.wordpress' => (new WordpressController())->setApp($this->app)
                            ->setImagePlaceholder(get_template_directory() . '/dist/images/holder/default.png'),
                    ]
                );

                /** MIDDLEWARES */
                Router::setMiddlewareStack(
                    [
                        'app.logged-in'  => (new LoggedInMiddleware())->setApp($this->app),
                        'app.logged-out' => (new LoggedOutMiddleware())->setApp($this->app),
                    ]
                );

                Router::group(
                    '/',
                    function (RouteGroup $router) {
                        if ($this->app->config('authentication')) {
                            // -- Authentification.
                            $router->middleware('app.logged-in');
                            Router::group(
                                '/',
                                function (RouteGroup $router) {
                                    $router->get('/authentification', ['app.auth', 'signin'])->setName(
                                        'authentication'
                                    );
                                    $router->post('/authentification', ['app.auth', 'signin']);
                                }
                            )->middleware('app.logged-out');
                        }

                        // -- Formulaire de contact.
                        $endpoint = ($post = PageHook::get('contact')->post()) ? $post->getSlug() : '/contact';
                        $router->get($endpoint, ['app.contact', 'index'])->setName('contact')->setWpQuery(!!$post);
                        $router->post($endpoint, ['app.contact', 'index'])->setWpQuery(!!$post);

                        /** UTILS (optionnel) */
                        // -- Accueil.
                        $router->get('/', ['app.utils', 'welcome'])->setName('welcome');
                        // -- Styles de l'éditeur.
                        $router->get('/styles-editeur', ['app.utils', 'editorStyles'])->setName('editor-styles');
                        // -- Présentation des fonctionnalités.
                        $router->get('/playground', ['app.utils', 'playground'])->setName('playground');
                        // -- Ressources utiles.
                        $router->get('/resources', ['app.utils', 'resources'])->setName('resources');
                        // -- Journal des modifications.
                        $router->get('/changelog', ['app.utils', 'changelog'])->setName('changelog');
                        /**/

                        // -- Wordpress.
                        $router->get('/{path:.*}', ['app.wordpress', 'handle'])->setWpQuery(true)->setName('wordpress');
                    }
                );

                /** NAVBAR */
                $navbar['items'] = [];
                // -- Actualités
                if (get_option('page_for_posts')) {
                    $navbar['items'][] = [
                        'attrs'   => [
                            'href' => get_post_type_archive_link('post'),
                        ],
                        'content' => __('Actualités', 'theme'),
                    ];
                }
                // -- Styles de l'éditeur
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('editor-styles'),
                    ],
                    'content' => __('Styles', 'theme'),
                    'tag'     => 'a',
                ];
                // -- Page 404
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Url::root('/404')->render(),
                    ],
                    'content' => __('Page 404', 'theme'),
                    'tag'     => 'a',
                ];
                // -- Formulaire de contact
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('contact'),
                    ],
                    'content' => __('Contact', 'theme'),
                    'tag'     => 'a',
                ];
                // -- Présentation des fonctionnalités
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('playground'),
                    ],
                    'content' => __('Fonctionnalités', 'theme'),
                    'tag'     => 'a',
                ];
                // -- Ressources utiles
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('resources'),
                    ],
                    'content' => __('Ressources', 'theme'),
                    'tag'     => 'a',
                ];
                // -- Journal des modifications
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('changelog'),
                    ],
                    'content' => __('Changelog', 'theme'),
                    'tag'     => 'a',
                ];
                Partial::get('navbar')::setDefaults($navbar);
                /**/
            },
            999999
        );
    }
}