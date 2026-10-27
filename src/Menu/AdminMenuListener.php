<?php

namespace Arobases\SyliusCustomerSupportPlugin\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

final class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $sales = $event->getMenu()->getChild('sales');
        if (null === $sales) {
            return;
        }

        $sales->addChild('customer_support', [
            'route' => 'arobases_sylius_customer_support_plugin_admin_customer_support_index',
            'extras' => ['routes' => [
                ['route' => 'arobases_sylius_customer_support_plugin_admin_customer_support_update'],
            ]],
        ])->setLabel('arobases_sylius_customer_support_plugin.menu.admin.customer_support')->setLabelAttribute('icon', 'tabler:message-circle');
    }
}
