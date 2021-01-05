<?php

declare(strict_types=1);

namespace App;

use tiFy\Support\ParamsBag;
use tiFy\Support\Proxy\View;
use tiFy\Support\Env;

class Config extends ParamsBag
{
    use AppAwareTrait;

    /**
     * Instance de la liste des assets
     * @var array
     */
    protected $asset = [];

    /**
     * Instance de la liste des métabalises.
     * @var ParamsBag|null
     */
    protected $metaTags;


    /**
     * Ordre d'affichage des méta-balises.
     * @var string[]
     */
    protected $metaTagsPriority = [];

    /**
     * Instance de la configuration des styles.
     * @var ParamsBag|null
     */
    protected $style;

    /**
     * Récupération de l'instance des assets| du chemin relatif vers un asset.
     *
     * @param string|null $key Clé d'indice de configuration
     * @param mixed $default Valeur de retour par défaut
     *
     * @return ParamsBag|mixed
     */
    public function asset(?string $key = null, $default = null)
    {
        return is_null($key) ? $this->asset : ($this->asset[$key] ?? $default);
    }

    /**
     * @inheritdoc
     */
    public function defaults(): array
    {
        return [
            // Méta-balises.
            'meta-tags'      => [
                /**
                 * @param $title bool|string|array {
                 *   'after'     => '',
                 *   'before'    => '',
                 *   'content'   => '',
                 *   'separator' => ' | ',
                 * }
                 */
                'title'    => true,
                'meta'     => [
                    'format-detection' => 'telephone=no',
                    'robots'           => Env::isProd() ? 'index, follow' : 'none',
                    'viewport'         => 'width=device-width, initial-scale=1, shrink-to-fit=no',
                ],
                'priority' => [
                    'description',
                    'keywords',
                    'robots',
                    'author',
                    'designer',
                    'viewport',
                    'format-detection',
                ],
            ],
            'authentication' => false,
            // Liste d'options partagées, disponibles dans la vue.
            'share'          => [
                // Numéro de version
                'version' => '2.0.16',
            ],
        ];
    }

    /**
     * Récupération de l'instance ou configuration ou récupération de meta-balise.
     *
     * @param string|array|Config|null $key Clé d'indice|Liste des métabalise à définir.
     * @param mixed $default Valeur de retour par défaut.
     *
     * @return ParamsBag|int|string|array|object
     */
    public function metaTags($key = null, $default = null)
    {
        if (!isset($this->metaTags) || is_null($this->metaTags)) {
            $this->metaTags = new ParamsBag();
        }

        if (is_null($key)) {
            return $this->metaTags;
        } elseif (is_array($key)) {
            return $this->metaTags->set($key);
        } else {
            return $this->metaTags->get($key, $default);
        }
    }

    /**
     * @inheritdoc
     */
    public function parse(): self
    {
        parent::parse();

        if ($share = $this->get('share', [])) {
            View::share('app', $share);
        }

        $this->asset = file_exists(get_stylesheet_directory() . '/dist/manifest.json')
            ? json_decode(file_get_contents(get_stylesheet_directory() . '/dist/manifest.json'), true) : [];

        $styleConfig = file_exists(get_stylesheet_directory() . '/style.config.json')
            ? json_decode(file_get_contents(get_stylesheet_directory() . '/style.config.json'), true) : [];
        $this->style = (new ParamsBag())->set($styleConfig);

        $this->metaTagsPriority = $this->pull('meta-tags.priority', []);
        $this->metaTags()->set('title', $this->pull('meta-tags.title'))->set($this->pull('meta-tags.meta', []));

        return $this;
    }

    /**
     * Traitement de la liste de méta-balises.
     *
     * @return ParamsBag
     */
    public function parseMetaTags(): ParamsBag
    {
        if ($title = $this->metaTags()->pull("title")) {
            if (is_bool($title)) {
                $sep = ' | ';
                $title = ($title = trim(wp_title('', false)))
                    ? $title . $sep . get_bloginfo('name')
                    : get_bloginfo('name') . $sep . get_bloginfo('description');
            } elseif (is_array($title)) {
                $title = array_merge(
                    [
                        'after'     => '',
                        'before'    => '',
                        'content'   => '',
                        'separator' => ' | ',
                    ],
                    $title
                );

                $parts = [];
                if (!empty($title['before'])) {
                    $parts[] = $title['before'];
                }

                if (!empty($title['content'])) {
                    $parts[] = $title['content'];
                } else {
                    $parts[] = trim(wp_title('', false));
                }

                if (!empty($title['after'])) {
                    $parts[] = $title['after'];
                }
                $title = !empty($parts) ? implode($title['separator'] ?? '', $parts) : null;
            }

            if (is_string($title)) {
                $this->metaTags()->set('title', $title);
            }
        }

        foreach ($this->metaTagsPriority as $key) {
            if ($value = $this->metaTags()->pull($key)) {
                $this->metaTags()->set($key, $value);
            }
        }

        return $this->metaTags();
    }

    /**
     * Récupération de la configuration des styles.
     *
     * @param string|null $key Clé d'indice de configuration
     * @param mixed $default Valeur de retour par défaut
     *
     * @return ParamsBag|mixed
     */
    public function style(?string $key = null, $default = null)
    {
        return is_null($key) ? $this->style : $this->style->get($key, $default);
    }
}