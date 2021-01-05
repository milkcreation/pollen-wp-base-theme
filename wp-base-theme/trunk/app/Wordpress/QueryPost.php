<?php declare(strict_types=1);

namespace App\Wordpress;

use tiFy\Wordpress\Query\QueryPost as BaseQueryPost;

class QueryPost extends BaseQueryPost
{
    /**
     * Récupération du titre alternatif bas.
     *
     * @return string
     */
    public function getAltBottomTitle(): string
    {
        return $this->getMetaSingle('_alt_bottom_title', '') ?: $this->getTitle();
    }

    /**
     * Récupération du titre alternatif haut.
     *
     * @return string
     */
    public function getAltTopTitle(): string
    {
        return $this->getMetaSingle('_alt_top_title', '');
    }

    /**
     * Récupération de la bannière des page de flux.
     *
     * @param array $attrs
     *
     * @return string
     */
    public function getBannerImg(array $attrs = []): string
    {
        if (!$id = $this->getMetaSingle('_banner_img', 0)) {
            return $this->getThumbnail('banner', $attrs);
        } elseif ($img = wp_get_attachment_image($id, 'banner', false, $attrs)) {
            return $img;
        }

        return '';
    }

    /**
     * Récupération du titre bas des publications apparentées.
     *
     * @return string
     */
    public function getChildrenBottomTitle(): string
    {
        return $this->getMetaSingle('_children_bottom_title', '') ?: $this->getTitle();
    }

    /**
     * Récupération du titre haut des publications apparentées.
     *
     * @return string
     */
    public function getChildrenTopTitle(): string
    {
        return $this->getMetaSingle('_children_top_title', '') ?: __('En relation avec', 'theme');
    }

    /**
     * Récupération du title bas des éléments de flux associés.
     *
     * @return string
     */
    public function getRelatedBottomTitle(): string
    {
        return $this->getMetaSingle('_related_bottom_title', '') ? : '';
    }

    /**
     * Récupération du title haut des élément de flux associés.
     *
     * @return string
     */
    public function getRelatedTopTitle(): string
    {
        return $this->getMetaSingle('_related_top_title', '') ? : '';
    }

    /**
     * Récupération de l'image d'entête.
     *
     * @param array $attrs
     *
     * @return string
     */
    public function getHeaderImg(array $attrs = []): string
    {
        if (!$id = $this->getMetaSingle('_header_img', 0)) {
            return $this->getThumbnail('header', $attrs);
        } elseif ($img = wp_get_attachment_image($id, 'header', false, $attrs)) {
            return $img;
        }

        return '';
    }
}