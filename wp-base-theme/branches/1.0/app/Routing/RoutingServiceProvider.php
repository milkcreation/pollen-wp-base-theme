<?php declare(strict_types=1);

namespace App\Routing;

use App\App;
use App\Controller\DefaultController;
use App\Controller\DemoController;
use App\Controller\AuthenticationController;
use App\Middleware\LoggedInMiddleware;
use App\Middleware\LoggedOutMiddleware;
use tiFy\Container\ServiceProvider;
use tiFy\Wordpress\Contracts\Routing\RouteGroup;
use tiFy\Wordpress\Proxy\Router;
use tiFy\Support\Proxy\Partial;
use tiFy\Support\Proxy\Url;

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

        add_action('init', function () {
            /** CONTROLEURS */
            Router::setControllerStack([
                'app.auth'    => (new AuthenticationController())->setApp($this->app),
                'app.default' => (new DefaultController())->setApp($this->app)
                    ->setImagePlaceholder(get_template_directory() . '/dist/images/holder/default.png'),
                'app.demo'    => (new DemoController())->setApp($this->app),
            ]);

            /** MIDDLEWARES */
            Router::setMiddlewareStack([
                'app.logged-in'  => (new LoggedInMiddleware())->setApp($this->app),
                'app.logged-out' => (new LoggedOutMiddleware())->setApp($this->app),
            ]);

            Router::group('/', function (RouteGroup $router) {
                $navbar = ['items' => []];

                // -- Authentification
                if ($this->app->config('authentication')) {
                    $router->middleware('app.logged-in');

                    Router::group('/', function (RouteGroup $router) {
                        $router->get('/authentification', ['app.auth', 'signin'])->setName('authentication');
                        $router->post('/authentification', ['app.auth', 'signin']);
                    })->middleware('app.logged-out');
                }

                if (get_option('page_for_posts')) {
                    $navbar['items'][] = [
                        'attrs'   => [
                            'href' => get_post_type_archive_link('post'),
                        ],
                        'content' => __('Actualités', 'theme')
                    ];
                }

                // -- Styles de l'éditeur
                $router->get('/editor-styles', ['app.default', 'editorStyles'])->setName('editor-styles');
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('editor-styles'),
                    ],
                    'content' => __('Styles de l\'éditeur', 'theme')
                ];

                // -- Page 404
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Url::root('/404')->render(),
                    ],
                    'content' => __('Page 404', 'theme')
                ];

                /** DEMO (optionnel) */
                // -- Présentation des fonctionnalités
                $router->get('/playground', ['app.demo', 'playground'])->setName('playground');
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('playground'),
                    ],
                    'content' => __('Fonctionnalités', 'theme')
                ];

                // -- Journal des modifications
                $router->get('/changelog', ['app.demo', 'changelog'])->setName('changelog');
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('changelog'),
                    ],
                    'content' => __('Journal des modifications', 'theme')
                ];

                // -- Ressources utiles
                $router->get('/resources', ['app.demo', 'resources'])->setName('resources');
                $navbar['items'][] = [
                    'attrs'   => [
                        'href' => Router::url('resources'),
                    ],
                    'content' => __('Ressources utiles', 'theme')
                ];
                /**/

                Partial::get('navbar')::setDefaults($navbar);

                // -- Point d'entrée global
                $router->get('/{path:.*}', ['app.default', 'handle'])->setWpQuery(true)->setName('bootstrap');
            });
        }, 999999);
    }
}