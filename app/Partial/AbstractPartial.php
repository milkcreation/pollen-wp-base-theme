<?php

declare(strict_types=1);

namespace App\Partial;

use App\App;
use App\AppAwareTrait;
use tiFy\Partial\Contracts\PartialContract;
use tiFy\Partial\PartialDriver;

abstract class AbstractPartial extends PartialDriver
{
    use AppAwareTrait;

    /**
     * @param App $app
     * @param PartialContract $partialManager
     */
    public function __construct(App $app, PartialContract $partialManager)
    {
        $this->setApp($app);
        parent::__construct($partialManager);
    }

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return get_template_directory() . '/views/partial/' . $this->getAlias();
    }
}