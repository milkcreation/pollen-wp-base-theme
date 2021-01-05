<?php

declare(strict_types=1);

namespace App;

use tiFy\Container\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var App $app */
        $app = $this->getContainer()->get('app');

        $this->getContainer()->share('app.assets', (new Assets())->setApp($app));
        $this->getContainer()->share(
            'app.config',
            (new Config())
                ->setApp($app)->set(config('app.config', []))->parse()
        );
    }
}