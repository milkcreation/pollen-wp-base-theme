<?php

/**
 * @var App\View $this
 */
?>
<h2><?php _e('Champs de formulaire', 'theme'); ?></h2>
<?php $this->insert("app::playground/field/suggest", $this->all()); ?>
