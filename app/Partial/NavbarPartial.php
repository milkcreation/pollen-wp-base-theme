<?php

declare(strict_types=1);

namespace App\Partial;

use tiFy\Support\Arr;
use tiFy\Support\Proxy\Url;

class NavbarPartial extends AbstractPartial
{
    /**
     * @inheritDoc
     */
    public function render(): string
    {
        $items = array_values($this->get('items', []));
        $key = (int)ceil(count($items) / 2);
        $items = Arr::insertAfter(
            $items,
            [
                'attrs'   => [
                    'class' => 'Navbar-menuItemLink--logo',
                    'href'  => Url::root('/')->render(),
                ],
                'content' => $this->app()->img('svg/logo-mono.svg'),
            ],
            $key
        );

        $this->set(
            [
                'attrs.data-control' => 'admin-bar-pos',
                'items'              => array_map(
                    function ($item) {
                        $item['attrs'] = $item['attrs'] ?? [];

                        $item['tag'] = $item['tag'] ?? (isset($item['attrs']['href']) ? 'a' : 'div');

                        $class = $item['attrs']['class'] ?? '';

                        switch ($item['tag']) {
                            case 'a' :
                                $item['attrs']['class'] = sprintf('%s Navbar-menuItemLink', $class);
                                break;
                        }

                        return $item;
                    },
                    $items
                ),
            ]
        );

        return parent::render();
    }
}