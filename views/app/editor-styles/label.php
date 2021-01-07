<?php
/**
 * @var App\View $this
 * @var string $base_tmpl
 * @var array $styles
 */
?>
<?php foreach(range(1,3) as $i) : ?>
    <p><span class="Label--<?php echo $i; ?>"><?php printf('Étiquette #%d Standard', $i); ?></span></p>
    <p><span class="Label--<?php echo $i; ?> Label--alt"><?php printf('Etiquette #%d Alternative', $i); ?></span></p>
<?php endforeach; ?>