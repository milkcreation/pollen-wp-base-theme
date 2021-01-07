<?php
/**
 * @var tiFy\Partial\PartialViewInterface $this
 * @var tiFy\Wordpress\Contracts\Query\QueryPost|null $post
 */

?>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="ArticleHeader-breadcrumb">
                <?php
                echo partial('breadcrumb', $this->get('breadcrumb')); ?>
            </div>
        </div>
    </div>
</div>
