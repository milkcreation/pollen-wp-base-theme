<?php
/**
 * @var App\View $this
 * @var string $base_tmpl
 * @var array $styles
 */
?>
<?php if ($this->get('styles.colors')) : ?>
<span class="Preview-title">Couleurs</span>
<?php $this->insert("${base_tmpl}_colors", $this->all()); ?>
<?php endif; ?>

<span class="Preview-title">Titrailles</span>
<?php $this->insert("${base_tmpl}_title"); ?>

<span class="Preview-title">Paragraphes standards</span>
<?php $this->insert("${base_tmpl}_paragraph"); ?>

<span class="Preview-title">Paragraphes sans espaces</span>
<?php $this->insert("${base_tmpl}_paragraph-alt"); ?>

<span class="Preview-title">Séparateurs de paragraphes</span>
<?php $this->insert("${base_tmpl}_hr"); ?>

<span class="Preview-title">Styles des textes</span>
<?php $this->insert("${base_tmpl}_text"); ?>

<span class="Preview-title">Liens</span>
<?php $this->insert("${base_tmpl}_link"); ?>

<span class="Preview-title">Listes</span>
<div><b>Listes à puces</b></div>
<?php $this->insert("${base_tmpl}_list-bullet"); ?>

<div><b>Listes ordonnées</b></div>
<?php $this->insert("${base_tmpl}_list-order"); ?>

<div><b>Listes de descriptions</b></div>
<?php $this->insert("${base_tmpl}_list-desc"); ?>

<span class="Preview-title">Bloc de citation</span>
<?php $this->insert("${base_tmpl}_citation"); ?>

<span class="Preview-title">Tableau</span>
<?php $this->insert("${base_tmpl}_table"); ?>

<span class="Preview-title">Collection de boutons</span>
<?php $this->insert("${base_tmpl}_button"); ?>

<span class="Preview-title">Collection d'étiquettes</span>
<?php $this->insert("${base_tmpl}_label"); ?>

<span class="Preview-title">Colonnage</span>
<?php $this->insert("${base_tmpl}_column"); ?>

<span class="Preview-title">Collections d'icônes</span>
<div><b>Icônes Wordpress</b></div>
<?php $this->insert("${base_tmpl}_icon-dashicons"); ?>

<div><b>Icônes FontAwesome</b></div>
<?php $this->insert("${base_tmpl}_icon-fontawesome"); ?>

<span class="Preview-title">Galerie d'images</span>
<?php $this->insert("${base_tmpl}_gallery"); ?>