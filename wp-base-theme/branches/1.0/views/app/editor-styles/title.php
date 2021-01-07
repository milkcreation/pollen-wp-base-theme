<?php
/**
 * @var App\View $this
 * @var string $base_tmpl
 * @var array $styles
 */
?>
<?php foreach(range(1,6) as $i) : ?>
<h<?php echo $i; ?>><?php printf(__('Titres de niveau #%d', 'theme'), $i); ?></h<?php echo $i; ?>>
<?php endforeach; ?>