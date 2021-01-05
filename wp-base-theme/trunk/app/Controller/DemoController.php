<?php

declare(strict_types=1);

namespace App\Controller;

use App\AppAwareTrait;
use Parsedown;
use tiFy\Contracts\Partial\Breadcrumb;
use tiFy\Contracts\Http\Response;
use tiFy\Routing\BaseController;
use tiFy\Support\Proxy\Partial;
use tiFy\Support\Proxy\Url;

class DemoController extends BaseController
{
    use AppAwareTrait;

    /**
     * Prévisualisation des styles de l'éditeur.
     *
     * @return Response
     */
    public function changelog(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.singular');
                wp_enqueue_script('app.singular');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--changelog';
                return $classes;
            }
        );
        // Meta Balises.
        $this->app()->config()->metaTags(
            [
                'title'  => __('Journal des modifications', 'theme'),
                'robots' => 'none',
            ]
        );
        // Fil d'ariane.
        /** @var Breadcrumb $breadcrumb */
        $breadcrumb = Partial::get('breadcrumb');
        $breadcrumb->main()->add(
            [
                'content' => __('Accueil', 'theme'),
                'url'     => Url::root('/')->render(),
            ]
        );
        $breadcrumb->main()->add(__('Journal des modification', 'theme'));
        // Configuration.
        $contentPath = get_template_directory() . '/CHANGELOG.md';
        $content = (file_exists($contentPath)) ? file_get_contents($contentPath) : '';
        $this->set(
            [
                'article-header' => [
                    'content' => false,
                    'post'    => false,
                ],
                'article-body'   => [
                    'content' => (new Parsedown())->text($content),
                    'post'    => false,
                ],
            ]
        );
        return $this->view('app::singular', $this->all());
    }

    /**
     * Page de présentation des fonctionnalités.
     *
     * @return Response
     */
    public function playground(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.playground');
                wp_enqueue_script('app.playground');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--playground';

                return $classes;
            }
        );
        // Meta Balise
        $this->app()->config()->metaTags(
            [
                'title'  => __('Fonctionnalités', 'theme'),
                'robots' => 'none',
            ]
        );
        // Fil d'ariane.
        /** @var Breadcrumb $breadcrumb */
        $breadcrumb = Partial::get('breadcrumb');
        $breadcrumb->main()->add(
            [
                'content' => __('Accueil', 'theme'),
                'url'     => Url::root('/')->render(),
            ]
        );
        $breadcrumb->main()->add(__('Fonctionnalités', 'theme'));
        // Configuration.
        $this->set(
            [
                'article-header' => [
                    'content' => false,
                    'post'    => false,
                ],
                'base_tmpl'      => 'app::playground/',
            ]
        );
        return $this->view('app::playground', $this->all());
    }

    /**
     * Page d'accueil.
     *
     * @return Response
     */
    public function resources(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.singular');
                wp_enqueue_script('app.singular');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--resources';

                return $classes;
            }
        );
        // Meta Balises.
        $this->app()->config()->metaTags(['title' => __('Ressources utiles', 'theme')]);
        // Fil d'ariane.
        /** @var Breadcrumb $breadcrumb */
        $breadcrumb = Partial::get('breadcrumb');
        $breadcrumb->main()->add(
            [
                'content' => __('Accueil', 'theme'),
                'url'     => Url::root('/')->render(),
            ]
        );
        $breadcrumb->main()->add(__('Ressources utiles', 'theme'));
        // Configuration.
        $contentPath = get_template_directory() . '/RESOURCES.md';
        $content = (file_exists($contentPath)) ? file_get_contents($contentPath) : '';
        $this->set(
            [
                'article-header' => [
                    'content' => false,
                    'post'    => false,
                ],
                'article-body'   => [
                    'content' => (new Parsedown())->text($content),
                    'post'    => false,
                ],
            ]
        );
        return $this->view('app::singular', $this->all());
    }
}