<?php
/**
 * @var App\View $this
 */
?>
<?php $this->layout('layout::demo'); ?>

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
            <?php if ($this->get('breadcrumb', null) !== false) : ?>
                <div class="row">
                    <div class="col-12">
                        <?php echo partial('breadcrumb', $this->get('breadcrumb', [])); ?>
                    </div>
                </div>
            <?php endif; ?>

            <div class="row">
                <?php while (have_posts()) : the_post(); ?>
                    <div class="col-4">
                        <?php echo partial('article-card'); ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </main>

    <?php if ($this->get('article-footer', null) !== false) : ?>
        <footer class="ContentFooter">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php echo partial('article-footer', $this->get('article-footer', [])); ?>
                    </div>
                </div>
            </div>
        </footer>
    <?php endif; ?>
</div>