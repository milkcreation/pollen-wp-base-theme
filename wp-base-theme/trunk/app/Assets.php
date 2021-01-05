<?php

declare(strict_types=1);

namespace App;

use tiFy\Support\Env;
use tiFy\Support\Proxy\Partial;
use tiFy\Support\Proxy\Url;

class Assets
{
    use AppAwareTrait;

    /**
     * CONSTRUCTEUR.
     *
     * @return void
     */
    public function __construct()
    {
        /** DECLARATION DES SCRIPTS */
        add_action('init', function () {
            if ($assets = $this->app()->config()->asset()) {
                foreach ($assets as $hookname => $src) {
                    if (preg_match('/(.*)(\.css)$/', $hookname, $matches)) {
                        $version = Env::isDev() && file_exists(ABSPATH . $src)
                            ? filemtime(ABSPATH . $src) : false;

                        wp_register_style($matches[1], Url::root($src)->render(), [], $version);
                    } elseif (preg_match('/(.*)(\.js)$/', $hookname, $matches)) {
                        $version = Env::isDev() && file_exists(ABSPATH . $src)
                            ? filemtime(ABSPATH . $src) : false;

                        wp_register_script($matches[1], Url::root($src)->render(), [], $version, true);
                    }
                }
            }
        });

        /** INTERFACE D'ADMINISTRATION */
        // Déclaration des scripts
        add_action('admin_enqueue_scripts', function (string $hookname) {
            wp_enqueue_style('admin');
            wp_enqueue_script('admin');

            switch($hookname) {
                case 'edit.php' :
                    wp_enqueue_style('admin.post-list');
                    wp_enqueue_script('admin.post-list');
                    break;
                case 'post.php' :
                case 'post-new.php' :
                    wp_enqueue_style('admin.post-edit');
                    wp_enqueue_script('admin.post-edit');
                    break;
                case 'settings_page_tify_options' :
                    wp_enqueue_style('admin.options');
                    wp_enqueue_script('admin.options');
                    break;
            }
        });

        // Favicons
        add_action('admin_head', function () {
            echo "<!-- Favicons -->";

            echo Partial::get('tag', [
                'tag'   => 'link',
                'attrs' => [
                    'id'    => false,
                    'class' => false,
                    'href'  => get_stylesheet_directory_uri() . '/dist/images/favicon/favicon.ico',
                    'type'  => 'image/x-icon',
                    'rel'   => 'icon',
                ],
            ]);

            echo Partial::get('tag', [
                'tag'   => 'link',
                'attrs' => [
                    'id'    => false,
                    'class' => false,
                    'href'  => get_stylesheet_directory_uri() . '/dist/images/favicon/favicon.png',
                    'type'  => 'image/png',
                    'rel'   => 'shortcut icon',
                ],
            ]);

            echo "<!-- / Favicons -->";
        }, 5);

        /** INTERFACE D'AUTHENTIFICATION */
        add_action('login_enqueue_scripts', function () {
            if ($css = $this->app()->config()->asset('wp.login.css')) {
                echo "<link rel=\"stylesheet\" href=\"{$css}\" type=\"text/css\" media=\"all\"/>";
            }

            if ($logo = $this->app()->config()->asset('src/images/svg/logo.svg') ?? null) {
                $logo = "data:image/svg+xml;base64," . base64_encode(file_get_contents(ABSPATH . $logo));

                echo "<style type=\"text/css\">body.login div#login h1 a {background-image: url('{$logo}');}</style>";
            }
        });
        add_action('login_footer', function () {
            if ($js = $this->app()->config()->asset('wp.login.js')) {
                echo "<script type=\"text/javascript\" src=\"{$js}\"></script>";
            }
        });

        /** INTERFACE UTILISATEUR */
        // Déclaration des scripts
        add_action('wp_enqueue_scripts', function () {
            wp_enqueue_style('outdated-browser');
            wp_enqueue_script('outdated-browser');

            wp_enqueue_style('app');
            wp_enqueue_script('app');
        });

        // Désenregistrement des scripts
        add_action('wp_enqueue_scripts', function () {
            wp_deregister_script('jquery');

            wp_deregister_style('wp-block-library');
            wp_deregister_style('wp-block-library-theme');
        }, 999999);

        // Meta-tags
        add_action('wp_head', function () {
            $tags = $this->app()->config()->parseMetaTags();

            if ($tags->has('title') && has_action('wp_head', '_wp_render_title_tag') == 1) {
                remove_action('wp_head', '_wp_render_title_tag', 1);
            }

            echo "<!-- SEO -->";
            foreach ($tags as $name => $content) {
                switch ($name) {
                    default:
                        echo Partial::get('tag', [
                            'tag'   => 'meta',
                            'attrs' => [
                                'id'      => false,
                                'class'   => false,
                                'name'    => $name,
                                'content' => $content,
                            ],
                        ]);
                        break;
                    case 'title' :
                        echo Partial::get('tag', [
                            'tag'     => $name,
                            'attrs'   => [
                                'id'    => false,
                                'class' => false,
                            ],
                            'content' => $content,
                        ]);
                        break;
                }
            }
            echo "<!-- / SEO -->";
        }, 0);

        /** Favicons */
        add_action('wp_head', function () {
            echo "<!-- Favicons -->";

            echo Partial::get('tag', [
                'tag'   => 'link',
                'attrs' => [
                    'id'    => false,
                    'class' => false,
                    'href'  => get_stylesheet_directory_uri() . '/dist/images/favicon/favicon.ico',
                    'type'  => 'image/x-icon',
                    'rel'   => 'icon',
                ],
            ]);

            echo Partial::get('tag', [
                'tag'   => 'link',
                'attrs' => [
                    'id'    => false,
                    'class' => false,
                    'href'  => get_stylesheet_directory_uri() . '/dist/images/favicon/favicon.png',
                    'type'  => 'image/png',
                    'rel'   => 'shortcut icon',
                ],
            ]);

            echo "<!-- / Favicons -->";
        }, 5);

        /** Preload */
        add_action('wp_head', function () {
            if ($assets = $this->app()->config()->asset()) {
                echo "<!-- Preload -->";

                foreach ($assets as $hookname => $src) {
                    // /\.(eof|ttf|woff|woff2)(\?.*)?$/
                    if (preg_match('/\.(woff2)$/', $hookname, $matches)) {
                        echo "<link rel=\"preload\" href=\"" . Url::root($src)->render() .
                            "\" as=\"font\" type=\"font/{$matches[1]}\" crossorigin>";
                    }
                }

                echo "<!-- / Preload -->";
            }
        }, 6);

        /** GOOGLE ANALYTICS */
        add_action('wp_head', function () {
            if ($ua = $this->app()->config('ua-code')) {
                echo "<!-- Global site tag (gtag.js) - Google Analytics -->" .
                    "<script async src=\"https://www.googletagmanager.com/gtag/js?id={$ua}\"></script>" .
                    "<script>" .
                    "window.dataLayer = window.dataLayer || [];" .
                    "function gtag() {" .
                    "dataLayer.push(arguments);" .
                    "}" .
                    "gtag('js', new Date());" .
                    "gtag('config', '{$ua}');" .
                    "</script>";
            }
        }, 999999);
    }
}