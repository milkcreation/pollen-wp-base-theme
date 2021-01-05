<?php

declare(strict_types=1);

namespace App\Partial;

use App\AppAwareTrait;
use tiFy\Partial\PartialDriver;

abstract class AbstractPartial extends PartialDriver
{
    use AppAwareTrait;

    /**
     * @inheritDoc
     */
    public function viewDirectory(): string
    {
        return get_template_directory() . '/views/partial/' . $this->getAlias();
    }
}