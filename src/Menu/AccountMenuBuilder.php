<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Menu;

use Knp\Menu\FactoryInterface;
use Knp\Menu\ItemInterface;
use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final class AccountMenuBuilder
{
    public const EVENT_NAME = 'sylius.menu.shop.account';

    /** @var FactoryInterface */
    private $factory;

    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(FactoryInterface $factory, EventDispatcherInterface $eventDispatcher)
    {
        $this->factory = $factory;
        $this->eventDispatcher = $eventDispatcher;
    }

    public function createMenu(array $options): ItemInterface
    {
        $menu = $this->factory->createItem('root');
        $menu->setLabel('sylius.menu.shop.account.header');

        $menu
            ->addChild('dashboard', ['route' => 'sylius_shop_account_dashboard'])
            ->setLabel('sylius.menu.shop.account.dashboard')
            ->setLabelAttribute('icon', 'home')
        ;
        $menu
            ->addChild('personal_information', ['route' => 'sylius_shop_account_profile_update'])
            ->setLabel('sylius.menu.shop.account.personal_information')
            ->setLabelAttribute('icon', 'user')
        ;
        $menu
            ->addChild('change_password', ['route' => 'sylius_shop_account_change_password'])
            ->setLabel('sylius.menu.shop.account.change_password')
            ->setLabelAttribute('icon', 'lock')
        ;
        $menu
            ->addChild('address_book', ['route' => 'sylius_shop_account_address_book_index'])
            ->setLabel('sylius.menu.shop.account.address_book')
            ->setLabelAttribute('icon', 'book')
        ;
        $menu
            ->addChild('order_history', ['route' => 'sylius_shop_account_order_index'])
            ->setLabel('sylius.menu.shop.account.order_history')
            ->setLabelAttribute('icon', 'cart')
        ;
        $menu
            ->addChild('arobases_customer_support', ['route' => 'arobases_sylius_customer_support_plugin_shop_account_customer_support_index'])
            ->setLabel('arobases_sylius_customer_support_plugin.menu.shop.account.customer_support')
            ->setLabelAttribute('icon', 'user')
        ;

        $this->eventDispatcher->dispatch(new MenuBuilderEvent($this->factory, $menu), self::EVENT_NAME);

        return $menu;
    }
}
