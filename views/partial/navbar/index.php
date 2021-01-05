<?php
/**
 * @var tiFy\Contracts\Partial\PartialView $this
 */
?>
<div <?php echo $this->htmlAttrs(); ?>>
    <div class="container-fluid p-0">
        <div class="row">
            <?php if ($items = $this->get('items', [])) : ?>
            <div class="col-12">
                <nav class="Navbar-menu">
                    <ul class="Navbar-menuItems">
                        <?php foreach($items as $item) : ?>
                        <li class="Navbar-menuItem">
                            <?php echo partial('tag', $item); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>