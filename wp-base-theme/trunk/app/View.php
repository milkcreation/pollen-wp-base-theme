<?php declare(strict_types=1);

namespace App;

use BadMethodCallException;
use Error;
use tiFy\Contracts\Filesystem\ImgFilesystem;
use tiFy\View\Factory\PlatesFactory;

/**
 * @method string|ImgFilesystem|null img(string|null $path = null, array|null $attrs = null)
 */
class View extends PlatesFactory
{
    /**
     * Liste des méthodes de délégation d'appel.
     * @var array
     */
    protected $mixins = [
        'img'
    ];

    /**
     * @inheritDoc
     */
    public function __call($name, $arguments)
    {
        if (in_array($name, $this->mixins)) {
            try {
                return app()->{$name}(...$arguments);
            } catch (Error $e) {
                throw new BadMethodCallException(
                    sprintf(
                        'Invalid App method Call, [%s] unavailable',
                        $name
                    )
                );
            }
        } else {
            return parent::__call($name, $arguments);
        }
    }
}