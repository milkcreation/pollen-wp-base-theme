<?php

declare(strict_types=1);

namespace App;

use App\Wordpress\QueryPost;
use App\Wordpress\QueryTerm;
use App\Wordpress\QueryUser;
use tiFy\Contracts\Container\Container;
use tiFy\Contracts\Filesystem\ImgFilesystem;
use tiFy\Contracts\Filesystem\LocalFilesystem;
use tiFy\Kernel\Application;
use tiFy\Support\Proxy\Storage;
use tiFy\Wordpress\Contracts\Query\QueryPost as QueryPostContract;
use tiFy\Wordpress\Contracts\Query\QueryTerm as QueryTermContract;
use tiFy\Wordpress\Contracts\Query\QueryUser as QueryUserContract;
use WP_Post;
use WP_Query;
use WP_Term;
use WP_Term_Query;
use WP_User;
use WP_User_Query;

class App extends Application
{
    /**
     * @inheritDoc
     */
    public function boot(): Container
    {
        parent::boot();

        // Déclaration des modèles d'objet type par défaut
        QueryPost::setBuiltInClass('any', QueryPost::class);
        QueryTerm::setBuiltInClass('any', QueryTerm::class);
        QueryUser::setBuiltInClass('any', QueryUser::class);

        add_action('wp', function () {
            /** Débogage, tests ... */
            if (isset($_REQUEST['debug'])) {
                _default_wp_die_handler('MODE DEBUG');
            } else {
                return null;
            }
        });
        return $this;
    }

    /**
     * Récupération de l'instance ou configuration ou récupération de paramètres de l'application.
     * {@internal Si $key est null > Retourne l'instance du controleur de configuration.}
     * {@internal Si $key est un tableau > Utilise le tableau en tant que liste des attributs de configuration.}
     * {@internal Sinon Récupère le paramètre $key où $default est la valeur de retour par défaut. Syntaxe à point
     * permise.}
     *
     * @param string|array|Config|null $key Indice de qualification du paramètre à récupérer|Liste des paramètres à
     *     définir.
     * @param mixed $default Valeur de retour par défaut du paramètre à récupérer.
     *
     * @return Config|int|bool|string|array|object|null
     */
    public function config($key = null, $default = null)
    {
        /* @var Config $config */
        $config = $this->get('app.config');

        if (is_null($key)) {
            return $config;
        } elseif (is_array($key)) {
            return $config->set($key);
        } else {
            return $config->get($key, $default);
        }
    }

    /**
     * Récupération d'image ou instance du système de fichier de stockage des images.
     *
     * @param string|null $path Chemin relatif vers fichier image.
     * @param array|null $attrs Liste des attributs de balise HTML.
     *
     * @return string|ImgFilesystem|null
     */
    public function img(?string $path = null, ?array $attrs = null)
    {
        /** @var ImgFilesystem $disk */
        $disk = Storage::disk('app.img');

        return is_null($path) ? $disk : $disk->render($path, $attrs);
    }

    /**
     * Instance du post courant ou du post associé à un identifiant de qualification.
     *
     * @param string|int|WP_Post|null $post
     *
     * @return QueryPost
     */
    public function post($post = null): ?QueryPostContract
    {
        return QueryPost::create($post);
    }

    /**
     * Liste des instances de posts courants|associés à une requête WP_Query|associés à des arguments.
     *
     * @param WP_Query|array|null $query
     *
     * @return QueryPost[]|array
     */
    public function posts($query = null): array
    {
        return QueryPost::fetch($query);
    }

    /**
     * Récupération de l'instance du gestionnaire de fichiers du dossier de stockage des ressources.
     *
     * @param string|null $path Chemin relatif vers fichier image.
     *
     * @return LocalFilesystem|string
     */
    public function resources(?string $path = null)
    {
        /** @var LocalFilesystem $fs */
        $fs = Storage::disk('app.resources');

        return is_null($path) ? $fs : $fs->path($path);
    }

    /**
     * Instance du terme de taxonomie courant ou terme de taxonomie associé à un identifiant de qualification.
     *
     * @param string|int|WP_Term|null $term
     *
     * @return QueryTerm
     */
    public function term($term = null): ?QueryTermContract
    {
        return QueryTerm::create($term);
    }

    /**
     * Liste des instances de termes de taxonomy associés à une requête WP_Query|associés à des arguments.
     *
     * @param WP_Term_Query|array $query
     *
     * @return QueryTerm[]|array
     */
    public function terms($query): array
    {
        return QueryTerm::fetch($query);
    }

    /**
     * Instance de l'utilisateur courant ou de l'utilisateur associé à un identifiant de qualification.
     *
     * @param string|int|WP_User|null $id
     *
     * @return QueryUser
     */
    public function user($id = null): ?QueryUserContract
    {
        return QueryUser::create($id);
    }

    /**
     * Liste des instances d'utilisateurs associés à une requête WP_User_Query|associés à des arguments.
     *
     * @param WP_User_Query|array $query
     *
     * @return QueryUser[]|array
     */
    public function users($query): array
    {
        return QueryUser::fetch($query);
    }
}