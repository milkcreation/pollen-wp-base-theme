<?php

declare(strict_types=1);

namespace App\Partial;

use App\App;
use tiFy\Container\ServiceProvider;
use tiFy\Partial\Contracts\PartialContract;

class PartialServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var App $app */
        $partialManager = $this->getContainer()->get(PartialContract::class);

        // Déclaration
        $this->getContainer()->add(NavbarPartial::class, function () use ($app) {
            return (new NavbarPartial($this->getContainer()->get('app'), $this->getContainer()->get(PartialContract::class)));
        });
        $partialManager->register('navbar', NavbarPartial::class);
    }
}