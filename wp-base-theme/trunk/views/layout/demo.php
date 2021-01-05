<?php
/**
 * @var App\View $this
 */
?>
<?php get_header(); ?>

    <div class="Site">
        <?php if ($this->get('navbar', true)) : ?>
            <header class="SiteHeader">
                <?php echo partial('navbar', [
                    'attrs' => [
                        'class' => '%s inViewport',
                    ],
                ]); ?>
            </header>
        <?php endif; ?>

        <main class="SiteBody">
            <?php echo $this->section('content'); ?>
        </main>

        <footer class="SiteFooter">
            <div class="Colophon">
                <div class="container">
                    <div class="row">
                        <div class="col-1">
                            <div class="Colophon-logo">
                                <?php echo partial('tag', [
                                    'attrs'   => [
                                        'class' => 'Colophon-logoLink',
                                        'href'  => home_url('/'),
                                        'title' => __('Retour à l\'accueil', 'theme'),
                                    ],
                                    'content' => $this->img('svg/logo-mono.svg', ['class' => 'svg-fluid']),
                                    'tag'     => 'a',
                                ]); ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="Copyright text-right">
                                <?php printf(
                                    __('Starter Kit Theme, version %s &copy; %s 2020'),
                                    $this->get('app.version'),
                                    partial('tag', [
                                        'attrs'   => [
                                            'href'  => 'https://milkcreation.fr',
                                            'title' => __('Visiter le site officiel', 'theme'),
                                        ],
                                        'content' => 'Milkcreation',
                                        'tag'     => 'a',
                                    ])
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
    </div>

<?php get_footer();