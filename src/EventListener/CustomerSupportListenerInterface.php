<?php


declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\EventListener;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;

interface CustomerSupportListenerInterface
{
    /**
     * Appelé après la mise à jour d'une ressource CustomerSupport.
     */
    public function postUpdate(ResourceControllerEvent $event): void;

    /**
     * Appelé après la création d'une ressource CustomerSupport.
     */
    public function postCreate(ResourceControllerEvent $event): void;
}
