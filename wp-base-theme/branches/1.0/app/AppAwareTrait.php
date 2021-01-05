<?php

declare(strict_types=1);

namespace App;

trait AppAwareTrait
{
    /**
     * Instance de l'application.
     * @var App|null
     */
    protected $app;

    /**
     * Récupération de l'instance de l'application.
     *
     * @return App|null
     */
    public function app(): ?App
    {
        return $this->app;
    }

    /**
     * Définition de l'application.
     *
     * @param App $app
     *
     * @return static
     */
    public function setApp(App $app): self
    {
        $this->app = $app;

        return $this;
    }
}
