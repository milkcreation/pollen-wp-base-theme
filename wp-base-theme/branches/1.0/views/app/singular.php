<?php

/**
 * @var App\View $this
 */
$this->layout('layout::base', $this->all());
?>
<div class="Content Content--singular">
    <?php
    if ($this->get('article-header', null) !== false) : ?>
        <header class="ContentHeader">
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-12">
                        <?php
                        echo partial('article-header', $this->get('article-header', [])); ?>
                    </div>
                </div>
            </div>
        </header>
    <?php
    endif; ?>

    <main class="ContentBody">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <?php echo partial('article-body', $this->get('article-body', [])); ?>
                </div>
            </div>
        </div>
    </main>

    <?php
    if ($this->get('article-footer', null) !== false) : ?>
        <footer class="ContentFooter">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <?php
                        echo partial('article-footer', $this->get('article-footer', [])); ?>
                    </div>
                </div>
            </div>
        </footer>
    <?php
    endif; ?>
</div>