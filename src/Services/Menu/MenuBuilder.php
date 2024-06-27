<?php

namespace App\Services\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\RequestStack;

class MenuBuilder
{
    public function __construct(
        private readonly FactoryInterface $factory,
        private readonly Security         $security,
    )
    {
    }

    public function createMainMenu(RequestStack $requestStack): ItemInterface
    {
        $menu = $this->factory->createItem('root')->setChildrenAttributes(['class' => 'nav']);

        $menu->addChild('Home', ['route' => 'app_main'])
            ->setAttribute('class', 'nav-item')
            ->setLinkAttribute('class', 'nav-link');

        if ($this->security->getUser()) {
            $menu->addChild('Codes', ['route' => 'shortener_list'])
                ->setAttribute('class', 'nav-item')
                ->setLinkAttribute('class', 'nav-link');
        }

        return $menu;
    }
}