<?php


namespace Arobases\SyliusCustomerSupportPlugin\EmailManager;

use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Sylius\Component\Core\Model\ChannelInterface;

interface SendNotificationAnswerEmailManagerInterface
{
    /**
     * Envoie un email de notification lorsqu'une réponse est ajoutée au support client.
     *
     * @param string $email Adresse email du destinataire
     * @param CustomerSupportAnswer $customerSupportAnswer Réponse du support client
     * @param ChannelInterface $channel Canal associé
     */
    public function sendNotificationAnswer(
        string                $email,
        CustomerSupportAnswer $customerSupportAnswer,
        ChannelInterface      $channel
    ): void;
}
