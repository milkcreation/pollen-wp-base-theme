<?php

declare(strict_types=1);

namespace App\Partial;

use App\App;
use tiFy\Container\ServiceProvider;
use tiFy\Support\Proxy\Partial;

class PartialServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var App $app */
        $app = $this->getContainer()->get('app');

        // Partial::register('navbar', (new NavbarPartial())->setApp($app));
    }
}