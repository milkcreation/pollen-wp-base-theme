<?php

/**
 * @var App\View $this
 */
if ($this->get('styles.colors')) : ?>
    <span class="Preview-title">Couleurs</span>
    <?php $this->insert('app::editor-styles/colors', $this->all()); ?>
<?php endif; ?>

    <span class="Preview-title">Titrailles</span>
    <?php $this->insert('app::editor-styles/title'); ?>

    <span class="Preview-title">Paragraphes standards</span>
    <?php $this->insert('app::editor-styles/paragraph'); ?>

    <span class="Preview-title">Paragraphes sans espaces</span>
    <?php $this->insert('app::editor-styles/paragraph-alt'); ?>

    <span class="Preview-title">Séparateurs de paragraphes</span>
    <?php $this->insert('app::editor-styles/hr'); ?>

    <span class="Preview-title">Styles des textes</span>
    <?php $this->insert('app::editor-styles/text'); ?>

    <span class="Preview-title">Liens</span>
    <?php $this->insert('app::editor-styles/link'); ?>

    <span class="Preview-title">Listes</span>
    <div><b>Listes à puces</b></div>
    <?php $this->insert('app::editor-styles/list-bullet'); ?>

    <div><b>Listes ordonnées</b></div>
    <?php $this->insert('app::editor-styles/list-order'); ?>

    <div><b>Listes de descriptions</b></div>
    <?php $this->insert('app::editor-styles/list-desc'); ?>

    <span class="Preview-title">Bloc de citation</span>
    <?php $this->insert('app::editor-styles/citation'); ?>

    <span class="Preview-title">Tableau</span>
    <?php $this->insert('app::editor-styles/table'); ?>

    <span class="Preview-title">Collection de boutons</span>
    <?php $this->insert('app::editor-styles/button'); ?>

    <span class="Preview-title">Collection d'étiquettes</span>
    <?php $this->insert('app::editor-styles/label'); ?>

    <span class="Preview-title">Colonnage</span>
    <?php $this->insert('app::editor-styles/column'); ?>

    <span class="Preview-title">Collections d'icônes</span>
    <div><b>Icônes Wordpress</b></div>
    <?php $this->insert('app::editor-styles/icon-dashicons'); ?>

    <div><b>Icônes FontAwesome</b></div>
    <?php $this->insert('app::editor-styles/icon-fontawesome'); ?>

    <span class="Preview-title">Galerie d'images</span>
    <?php $this->insert('app::editor-styles/gallery'); ?>