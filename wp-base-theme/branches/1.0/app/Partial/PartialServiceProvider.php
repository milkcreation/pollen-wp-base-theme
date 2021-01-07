<?php

declare(strict_types=1);

namespace App\Partial;

use tiFy\Container\ServiceProvider;
use tiFy\Partial\Contracts\PartialContract;

class PartialServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot(): void
    {
        /** @var PartialContract $partialManager */
        $partialManager = $this->getContainer()->get(PartialContract::class);
        // Configuration.
        $partialManager->setConfig(
            [
                'driver.article-header' => [
                    'viewer' => [
                        'override_dir' => get_template_directory() . '/views/partial/article-header',
                    ],
                ],
            ]
        );
        // Déclaration.
        $this->getContainer()->add(
            NavbarPartial::class,
            function () {
                return (new NavbarPartial(
                    $this->getContainer()->get('app'),
                    $this->getContainer()->get(PartialContract::class)
                ));
            }
        );
        $partialManager->register('navbar', NavbarPartial::class);
    }
}