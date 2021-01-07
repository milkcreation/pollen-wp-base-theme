<?php

declare(strict_types=1);

namespace App\Controller;

use App\AppAwareTrait;
use Parsedown;
use tiFy\Contracts\Http\Response;
use tiFy\Partial\Drivers\BreadcrumbDriverInterface;
use tiFy\Routing\BaseController;
use tiFy\Support\Proxy\Partial;
use tiFy\Support\Proxy\Url;

class UtilsController extends BaseController
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
                'title'       => __('Journal des modifications', 'theme'),
                'description' => __(
                    'Page répertoriant le journal des modifications apportées lors de la phase de développement du site (changelog).',
                    'theme'
                ),
                'robots'      => 'none',
            ]
        );
        remove_all_actions('wpseo_head');
        // Fil d'ariane.
        /** @var BreadcrumbDriverInterface $breadcrumb */
        $breadcrumb = Partial::get('breadcrumb');
        $breadcrumb->main()->add(
            [
                'content' => __('Accueil', 'theme'),
                'url'     => Url::root('/')->render(),
            ]
        );
        $breadcrumb->main()->add(__('Journal des modifications', 'theme'));
        // Configuration.
        $contentPath = get_template_directory() . '/CHANGELOG.md';
        $content = (file_exists($contentPath)) ? file_get_contents($contentPath) : '';
        $this->set(
            [
                'article-header' => [
                    'content' => false,
                    'title'   => false,
                ],
                'article-body'   => [
                    'content'        => apply_filters('the_content', (new Parsedown())->text($content)),
                    'content-editor' => true,
                ],
            ]
        );
        return $this->view('app::singular', $this->all());
    }

    /**
     * Prévisualisation des styles de l'éditeur.
     *
     * @return Response
     */
    public function editorStyles(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.editor-styles');
                wp_enqueue_script('app.editor-styles');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--editor_styles';
                return $classes;
            }
        );
        // Meta Balises.
        $this->app()->config()->metaTags(
            [
                'title'       => __('Présentation des styles', 'theme'),
                'description' => __('Page de presentation des styles du site.', 'theme'),
                'robots'      => 'none',
            ]
        );
        remove_all_actions('wpseo_head');
        // Fil d'ariane
        /** @var BreadcrumbDriverInterface $breadcrumb */
        $breadcrumb = Partial::get('breadcrumb');
        $breadcrumb->main()->add(
            [
                'content' => __('Accueil', 'theme'),
                'url'     => Url::root('/')->render(),
            ]
        );
        $breadcrumb->main()->add(__('Présentation des styles', 'theme'));
        // Configuration
        $this->set(
            [
                'article-header' => [
                    'title' => [
                        'content' => __('Présentation', 'theme'),
                        'after'   => __('des styles', 'theme'),
                    ],
                ],
                'styles'         => $this->app()->config()->style()->all(),
            ]
        );
        $this->set(
            'article-body',
            [
                'content'        => apply_filters('the_content', $this->render('app::editor-styles/all', $this->all())),
                'content-editor' => true,
            ]
        );
        return $this->view('app::editor-styles', $this->all());
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
                'title'       => __('Fonctionnalités', 'theme'),
                'description' => __('Page de présentation et de test des fonctionnalités du site.', 'theme'),
                'robots'      => 'none',
            ]
        );
        remove_all_actions('wpseo_head');
        // Fil d'ariane.
        /** @var BreadcrumbDriverInterface $breadcrumb */
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
                    'title'   => __('Test des fonctionnalités', 'theme'),
                    'content' => false,
                ],
            ]
        );
        $this->set(
            'article-body',
            [
                'content' => $this->render('app::playground/all', $this->all()),
            ]
        );
        return $this->view('app::playground', $this->all());
    }

    /**
     * Page des ressources.
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
        $this->app()->config()->metaTags(
            [
                'title'       => __('Ressources utiles', 'theme'),
                'description' => __(
                    'Liste de ressources utiles au développement et à l\'administration du site.',
                    'theme'
                ),
                'robots'      => 'none',
            ]
        );
        remove_all_actions('wpseo_head');
        // Fil d'ariane.
        /** @var BreadcrumbDriverInterface $breadcrumb */
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
                    'title'   => false,
                ],
                'article-body'   => [
                    'content'        => apply_filters('the_content', (new Parsedown())->text($content)),
                    'content-editor' => true,
                ],
            ]
        );
        return $this->view('app::singular', $this->all());
    }

    /**
     * Page de bienvenue
     *
     * @return Response
     */
    public function welcome(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.front-page');
                wp_enqueue_script('app.front-page');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--front_page';
                return $classes;
            }
        );
        // Meta Balises.
        $this->app()->config()->metaTags(
            [
                'title'       => __('Bienvenue dans PresstiFy', 'theme'),
                'description' => __(
                    'Page de bienvenue et de présentation du thème de démarrage Wordpress.',
                    'theme'
                ),
                'robots'      => 'none',
            ]
        );
        remove_all_actions('wpseo_head');
        // Configuration.
        $contentPath = get_template_directory() . '/README.md';
        $content = (file_exists($contentPath)) ? file_get_contents($contentPath) : '';
        $this->set(
            [
                'article-header' => [
                    'breadcrumb' => false,
                    'title'      => [
                        'content' => __('Bienvenue,', 'theme'),
                        'after'   => __('Merci d\'utiliser PresstiFy', 'theme'),
                    ],
                ],
                'article-body'   => [
                    'content'        => apply_filters('the_content', (new Parsedown())->text($content)),
                    'content-editor' => true,
                ],
            ]
        );
        return $this->view('app::welcome', $this->all());
    }
}