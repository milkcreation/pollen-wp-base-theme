<?php declare(strict_types=1);

namespace App\Wordpress;

use App\App;
use tiFy\Container\ServiceProvider;
use tiFy\Support\Proxy\Asset;
use tiFy\Support\Proxy\Router;
use tiFy\Support\Proxy\Url;
use WP_Admin_Bar, WP_Screen;

class WordpressServiceProvider extends ServiceProvider
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
            /**
             * Fonctionnalités de support du thème.
             * @see https://developer.wordpress.org/reference/functions/add_theme_support/
             */
            add_theme_support('customize-selective-refresh-widgets');
            add_theme_support('html5', ['comment-list', 'comment-form', 'search-form', 'gallery', 'caption']);
            add_theme_support('menus');
            add_theme_support('post-thumbnails');
            add_theme_support('title-tag');
            add_theme_support('align-wide');
            add_theme_support('admin-bar', ['callback' => '__return_false']);
            /**/

            /**
             * Déclaration de largeur de contenu du site.
             */
            global $content_width;
            if (!isset($content_width)) {
                $content_width = 1140;
            }
            /**/

            /**
             * Configuration des éditeur (classic & block).
             * @see https://developer.wordpress.org/block-editor/developers/themes/theme-support/
             */
            add_theme_support('wp-block-styles');
            add_theme_support('align-wide');
            add_theme_support('responsive-embeds');
            add_theme_support('custom-line-height');
            add_theme_support('editor-styles');
            add_theme_support('custom-units', '%', 'em');

            add_theme_support('editor-color-palette', [
                [
                    'name'  => __('Texte Régulier', 'theme'),
                    'slug'  => 'regular',
                    'color' => '#6D7983',
                ],
                [
                    'name'  => __('Principale', 'theme'),
                    'slug'  => 'primary',
                    'color' => '#55B3D2',
                ],
                [
                    'name'  => __('Secondaire', 'theme'),
                    'slug'  => 'secondary',
                    'color' => '#9CCA6B',
                ],
                [
                    'name'  => __('Blanc', 'theme'),
                    'slug'  => 'white',
                    'color' => '#FFF',
                ],
                [
                    'name'  => __('transparent', 'theme'),
                    'slug'  => 'transparent',
                    'color' => 'transparent',
                ]
            ]);

            add_theme_support('editor-gradient-presets', [
                [
                    'name'     => __('Dégradé de bleus', 'theme'),
                    'gradient' => 'transparent radial-gradient(closest-side at 50% 50%, #199FC8 0%, #0B5D93 100%) 0 0 no-repeat padding-box',
                    'slug'     => 'blues'
                ]
            ]);

            add_theme_support('disable-custom-font-sizes');
            add_theme_support('disable-custom-colors');
            add_theme_support('disable-custom-gradients');

            add_action('current_screen', function (WP_Screen $wp_screen)  {
                if ($wp_screen->is_block_editor()) {
                    add_editor_style(Url::root($this->app->config()->asset('wp.block-editor.css'))->render());
                } else {
                    $editor_styles = [Url::root($this->app->config()->asset('wp.editor.css'))->render()];
                    array_walk($editor_styles, function (&$url) {
                        return $url = str_replace(',', '%2C', $url);
                    });
                    add_editor_style($editor_styles);
                }
            });
            /**/

            /**
             * Déclaration des menus.
             * {@internal Le support de menus doit être actif.}
             * /
            register_nav_menu('header-nav-menu', __('Menu de navigation du principal', 'theme'));
            register_nav_menu('footer-nav-menu', __('Menu de navigation pied de page', 'theme'));
            /**/

            /**
             * Déclaration des tailles de miniatures personnalisées.
             * {@internal Le support de miniatures "post-thumbnails" doit être actif.}
             * /
            add_image_size('archive', 480, 280, true);
            add_image_size('single', 640, 9999, false);
            /**/

            /**
             * Forcage des dimensions de la miniature la plus large à la largeur du contenu du site.
             * {@internal La globale $content_width doit être définie.}
             */
            add_filter('option_large_size_w', function () { return 1920; });
            add_filter('option_large_size_h', function () { return 9999; });
            /**/

            /**
             * Désactivation des styles de la galerie.
             */
            add_filter('use_default_gallery_style', '__return_false');
            /**/
        }, 25);

        /**
         * Bouton d'accès au styles du site (Barre d'admin)
         */
        add_action('admin_bar_menu', function (WP_Admin_Bar $wp_admin_bar) {
            $wp_admin_bar->add_node([
                'id'    => 'editorStyles',
                'title' => '<span class="ab-icon"></span>' .
                    '<span class="ab-label">' . __('Styles', 'theme') . '</span>',
                'href'  => Router::url('editor-styles'),
                'meta'  => [
                    'class' => 'editorStyles',
                    'title' => __('Accèder à la page des styles', 'theme'),
                ],
            ]);
        }, 999999);

        add_action('wp_head', function () {
            Asset::setInlineCss('#wpadminbar #wp-admin-bar-editorStyles .ab-icon::before {content:"\f535";top: 2px;}');
        }, -1);

        add_action('admin_head', function () {
            Asset::setInlineCss('#wpadminbar #wp-admin-bar-editorStyles .ab-icon::before {content:"\f535";top: 2px;}');
        }, -1);


        /**
         * Définition de la langue
         */
        add_action('tify_load_textdomain', function () {
            load_theme_textdomain('theme', get_template_directory() . '/languages');
        });
        /**/

        /**
         * Contenus embarqués
         */
        add_filter('embed_oembed_html', function ($html) {
            return '<div class="responsive-embed">' . $html . '</div>';
        }, 99);

        /**  * /
        add_filter('the_content', function ($content) {
            $pattern = '~<iframe.*</iframe>|<embed.*</embed>~';
            preg_match_all($pattern, $content, $matches);
            foreach ($matches[0] as $match) {
            $wrappedframe = '<div class="video-responsive-embed">' . $match . '</div>';
            $content = str_replace($match, $wrappedframe, $content);
            }
            return $content;
            });
        /**/

        /**
         * Galerie d'images
         */
        // Choix du lien d'une image de la galerie par défaut.
        add_filter('media_view_settings', function ($settings) {
            $settings['galleryDefaults']['link'] = 'file';
            return $settings;
        });

        // Force le lien de la galerie vers le fichier original.
        add_filter('shortcode_atts_gallery', function ($atts) {
            $atts['link'] = 'file';
            return $atts;
        });
        /**/

        /**
         * Désactivation de la vérification d'email de l'administrateur principal.
         */
        add_filter('admin_email_check_interval', '__return_false');
        /**/
    }
}