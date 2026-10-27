<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AccountMenuListener
{
    public function addAccountMenuItems(MenuBuilderEvent $event): void
    {
        $event->getMenu()
            ->addChild('arobases_customer_support', ['route' => 'arobases_sylius_customer_support_plugin_shop_account_customer_support_index'])
            ->setLabel('arobases_sylius_customer_support_plugin.menu.shop.account.customer_support')
            ->setLabelAttribute('icon', 'tabler:message-circle')
        ;
    }
}
