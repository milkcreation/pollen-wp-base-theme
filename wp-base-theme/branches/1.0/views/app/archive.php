<?php

/**
 * @var App\View $this
 */
$this->layout('layout::base', $this->all());
?>
<div class="Content Content--archive">
    <?php if ($this->get('article-header', null) !== false) : ?>
        <header class="ContentHeader">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-12">
                        <?php echo partial('article-header', $this->get('article-header', [])); ?>
                    </div>
                </div>
            </div>
        </header>
    <?php endif; ?>

    <main class="ContentBody">
        <div class="container">
            <div class="row">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="col-4">
                        <?php echo partial(
                            'article-card',
                            [
                                'readmore' => [
                                    'attrs' => [
                                        'class' => 'ArticleCard-readmoreLink Button--1',
                                    ],
                                ],
                            ]
                        ); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <footer class="ContentFooter">
        <?php if ($pagination = partial('pagination')->render()) : ?>
        <div class="container-lg">
            <div class="row">
                <?php echo $pagination; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php if ($this->get('article-footer', null) !== false) : ?>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php echo partial('article-footer', $this->get('article-footer', [])); ?>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </footer>
</div>