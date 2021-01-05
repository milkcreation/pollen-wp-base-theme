<?php
/**
 * @var App\View $this
 */
?>
<?php $this->layout('layout::demo'); ?>

<div class="Content Content--welcome">
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

    <?php if ($this->get('article-body', null) !== false) : ?>
        <main class="ContentBody">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php echo partial('article-body', $this->get('article-body', [])); ?>
                    </div>
                </div>
            </div>
        </main>
    <?php endif; ?>

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