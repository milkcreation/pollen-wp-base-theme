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
    public function boot(): void
    {
        Storage::registerImg('app.img', get_stylesheet_directory() . '/dist/images');
        $resourcesPath = Env::get('APP_RESOURCES');
        Storage::registerLocal('app.resources', is_dir($resourcesPath) ? $resourcesPath : ABSPATH);
    }
}