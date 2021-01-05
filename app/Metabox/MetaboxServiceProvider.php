<?php declare(strict_types=1);

namespace App\Metabox;

use App\App;
use tiFy\Container\ServiceProvider;
use tiFy\Contracts\Metabox\MetaboxDriver;
use tiFy\Support\Proxy\Metabox;
use tiFy\Support\Proxy\PostType;
use WP_Post;

class MetaboxServiceProvider extends ServiceProvider
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

        add_action('after_setup_theme', function () {
            $postPath = get_template_directory() . '/views/admin/metabox/post-type';
            $postTypes = ['post', 'page'];

            foreach ($postTypes as $pt) {
                PostType::meta()
                    ->registerSingle($pt, '_alt_top_title')
                    ->registerSingle($pt, '_alt_bottom_title')
                    ->registerSingle($pt, '_children_top_title')
                    ->registerSingle($pt, '_children_bottom_title')
                    ->registerSingle($pt, '_related_top_title')
                    ->registerSingle($pt, '_related_bottom_title')
                    ->registerSingle($pt, '_thumbnail_id')
                    ->registerSingle($pt, '_banner_img')
                    ->registerSingle($pt, '_header_img');

                Metabox::add("{$pt}-display", [
                    'title' => __('Composition d\'affichage', 'title'),
                ])->setScreen("{$pt}@post_type")->setContext('tab');

                Metabox::add("{$pt}-display_global", [
                    'name'   => '_global_show',
                    'parent' => "{$pt}-display",
                    'title'  => __('Général', 'title'),
                    'viewer' => [
                        'directory' => "{$postPath}/composing/global",
                    ],
                ])->setScreen("{$pt}@post_type")->setContext('tab')
                    ->setHandler(function (MetaboxDriver $box, WP_Post $wp_post) {
                        $box->set('post', $this->app->post($wp_post));
                    });

                Metabox::add("{$pt}-display_single", [
                    'name'   => '_single_show',
                    'parent' => "{$pt}-display",
                    'title'  => __('Page de contenu', 'title'),
                    'viewer' => [
                        'directory' => "{$postPath}/composing/single",
                    ],
                ])
                    ->setScreen("{$pt}@post_type")->setContext('tab')
                    ->setHandler(function (MetaboxDriver $box, WP_Post $wp_post) {
                        $box->set('post', $this->app->post($wp_post));
                    });

                Metabox::add("{$pt}-display_archive", [
                    'name'   => '_archive_show',
                    'parent' => "{$pt}-display",
                    'title'  => __('Pages de flux', 'title'),
                    'viewer' => [
                        'directory' => "{$postPath}/composing/archive",
                    ],
                ])
                    ->setScreen("{$pt}@post_type")->setContext('tab')
                    ->setHandler(function (MetaboxDriver $box, WP_Post $wp_post) {
                        $box->set('post', $this->app->post($wp_post));
                    });

            }
        });
    }
}