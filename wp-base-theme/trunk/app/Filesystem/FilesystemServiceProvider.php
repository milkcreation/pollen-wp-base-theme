<?php

declare(strict_types=1);

namespace App\Filesystem;

use tiFy\Container\ServiceProvider;
use tiFy\Support\Proxy\Storage;
use tiFy\Support\Env;

class FilesystemServiceProvider extends ServiceProvider
{
    /**
     * @inheritDoc
     */
    public function boot()
    {
        Storage::registerImg('app.img', get_stylesheet_directory() . '/dist/images');
        Storage::registerLocal('app.resources', Env::get('APP_RESOURCES', ABSPATH));
    }
}