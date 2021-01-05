# Release Notes

## [v2.0.16 (2020-11-02)](https://svn.presstify.com/presstify-themes/starter-kit/tags/2.0.16...v2.0.16)

### Added

- Metaboxes composition d'affichage
- Editeur de styles : Bouton de la barre d'admin
- scss variables : methodes color() + fontWeight + fontFamily + gradient
- Page de gestion des changelog

### Changed

- Remplacement des occurences home_url({...}) par Url::root({...})
- Déclaration des dépendances de classe dédiée >> {Class#1, Class#2} supprimé
- `App\App.php` : QueryPost::setBuiltInClass('any') + QueryTerm::setBuiltInClass('any', QueryTerm::class); QueryUser::setBuiltInClass('any', QueryUser::class);
- Editeur de styles : Modification HR + Couleurs + Boucle boutons et labels
- Views : Gestion des éléménts de contenus désactivés
- `App\Assets.php` : Gestion des preload
- `App\Partial\NavbarPartial`: refonte

## [v2.0.15 (2020-11-02)](https://svn.presstify.com/presstify-themes/starter-kit/tags/2.0.15...v2.0.15)

### Changed

- `app\App.php` : Suppression de la methode meta + params > config
- `app\Assets.php` : Suppression de la déclaration des meta-tags > Config.php
- Ajout des assets prod du dossier dist
- `src/scss/mixins/_elements.scss` Modification des qualification ...-styles-{*} >> ...-{*}-styles
- Gestion de responsive-embed

### Added 

- `app\Config.php` : En remplacement de Params + Gestion des meta-tags + Gestion de style.config
- `app/Controller/AuthenticationController.php` : Contrôleur d'authentification dédié
- `app/Form/Authentication/Signin.php` : Formulaire d'authentification
- `app\Assets.php` : preload des fonts
- Styles du séparateur HR
- EditorStyles : Ajout des couleurs

### Fixed 

- Suppression de tb-set aux dépendances


## [v2.0.14 (2020-10-25)](https://svn.presstify.com/presstify-themes/starter-kit/tags/2.0.14...v2.0.14)


### Changed

- Suppression de la gestion ConditionnalTag par défaut
- `app/AppAwareTrait.php` : getApp() >> app() + modification des références ds fichiers connexes
- `app/Assets.php` : Gestion des déclaration assets via manifest.json + Suppression de registerStyle && registerScript + Correctif wp_head -> tag.title >> meta-tags.title
- `app/Controller/DefaultController.php` : Mise en file des scripts et styles associés au manifest
- `config/view.php` : Suppression demo
- `views/app/editor-styles/_button.php` : Button small + large + wide 

## [v2.0.13 (2020-10-12)](https://svn.presstify.com/presstify-themes/starter-kit/tags/2.0.13...v2.0.13)

### Changed 

- Suppression de la démo
- Contextualisation du chargement des assets
- Page de playground
- ArticlePartial >> ArticleBody

## [v2.0.12 (2020-10-03)](https://svn.presstify.comr/presstify-themes/starter-kit/tags/2.0.12...v2.0.12)

### Added

- Prise en charge de la librairie admin-bar-pos
- Prise en charge block editor (phase #1)
- Prise en charge du pseudo attributs disabled des boutons
- App.php methode users
- PrivacyLinkPartial


### Changed

- Modification de gestion du contexte wp.admin >> admin
- Partial Driver >> Suffixe de classe ...Partial
- Partial Driver >> Utilisation de l'alias
- Mise à jour de package.json + wepack.json dernière version stable
- Commentaires responsive bootstrap + Correctif contexte XL && XS

### Fixed

- Mode preview des pages en brouillon
- Ajout de la la page PrivacyPolicy dans demoController
- Désactivation de l'affichage des erreurs forcée dans wp-config (wp-project)
- Modification des assets scss && js >> mixins + fonts + variables à la racine
- Correctif font-awesome dans la vue preview
- App.php function img
- Encapsulation double quote des couleurs (incompatibilité bootstrap)
