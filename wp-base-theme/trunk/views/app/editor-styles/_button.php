<?php
/**
 * @var App\View $this
 * @var string $base_tmpl
 * @var array $styles
 */
?>
<?php foreach(range(1,3) as $i) : ?>
    <p><a class="Button--<?php echo $i; ?>" href="#"><?php printf('Bouton #%d Standard', $i); ?></a></p>
    <p><a class="Button--<?php echo $i; ?>" href="#" disabled><?php printf('Bouton #%d Standard Désactivé', $i); ?></a></p>
    <p><a class="Button--<?php echo $i; ?> Button--alt" href="#"><?php printf('Bouton #%d Alternatif', $i); ?></a></p>
    <p><a class="Button--<?php echo $i; ?> Button--alt" href="#" disabled><?php printf('Bouton #%d Alternatif Désactivé', $i); ?></a></p>
<?php endforeach; ?>

<span class="Preview-title">Styles de boutons</span>
<p><a class="Button--1 Button--small" href="#">Bouton Small</a></p>
<p><a class="Button--1 Button--large" href="#">Bouton Large</a></p>
<p><a class="Button--1 Button--wide" href="#">Bouton Pleine Page</a></p>