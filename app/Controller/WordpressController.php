<?php

declare(strict_types=1);

namespace App\Controller;

use App\AppAwareTrait;
use tiFy\Contracts\Http\Response;
use tiFy\Wordpress\Routing\BaseController;
use tiFy\Wordpress\Proxy\PageHook;

class WordpressController extends BaseController
{
    use AppAwareTrait;

    /**
     * Page 404.
     *
     * @return Response
     */
    public function is404(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.404');
                wp_enqueue_script('app.404');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--404';
                return $classes;
            }
        );
        // Configuration.
        $this->set(
            [
                'article-header' => [
                    'title' => [
                        'content' => __('Erreur 404', 'theme'),
                        'after'   => __('Page introuvable', 'theme'),
                    ],
                    'post'  => false,
                ],
            ]
        );
        return $this->view('app::404', $this->all());
    }

    /**
     * Page flux des archives.
     *
     * @return Response
     */
    public function isArchive(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.archive');
                wp_enqueue_script('app.archive');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--archive';
                return $classes;
            }
        );
        return $this->view('app::archive', $this->all());
    }

    /**
     * Page d'accueil.
     *
     * @return Response
     */
    public function isFrontPage(): Response
    {
        if (is_preview()) {
            return $this->isSingular();
        }
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
        return $this->view('app::front-page', $this->all());
    }

    /**
     * Page flux des actualités.
     *
     * @return Response
     */
    public function isHome(): Response
    {
        if ($page = get_option('page_for_posts')) {
            $post = $this->app()->post($page);
            $this->set(
                [
                    'article-header' => compact('post'),
                    'article-body'   => compact('post'),
                ]
            );
        }
        return $this->isArchive();
    }

    /**
     * Page de contenu page.
     *
     * @return Response
     */
    public function isPage(): Response
    {
        return $this->isSingular();
    }

    /**
     * Page de previsualisation d'article.
     *
     * @return Response
     */
    public function isPreview(): Response
    {
        return $this->isSingular();
    }

    /**
     * Page de politique de confidentialité.
     *
     * @return Response
     */
    public function isPostTypeArchive(): Response
    {
        // Mise en file des scripts.
        add_action(
            'wp_enqueue_scripts',
            function () {
                wp_enqueue_style('app.archive');
                wp_enqueue_script('app.archive');
            }
        );
        // Classes de la balise body.
        add_filter(
            'body_class',
            function ($classes) {
                $classes[] = 'Body--archive_' . get_post_type();
                return $classes;
            }
        );
        // Configuration.
        if ($hook = PageHook::current()) {
            $post = $hook->post();
            $this->set(
                [
                    'article-header' => compact('post'),
                    'article-body'   => compact('post'),
                ]
            );
        }
        return $this->view('app::archive', $this->all());
    }

    /**
     * Page de politique de confidentialité.
     *
     * @return Response
     */
    public function isPrivacyPolicy(): Response
    {
        return $this->isSingular();
    }

    /**
     * Page de contenu actualité.
     *
     * @return Response
     */
    public function isSingle(): Response
    {
        return $this->isSingular();
    }

    /**
     * Page d'article.
     *
     * @return Response
     */
    public function isSingular(): Response
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
                $classes[] = 'Body--singular';
                return $classes;
            }
        );
        return $this->view('app::singular', $this->all());
    }
}