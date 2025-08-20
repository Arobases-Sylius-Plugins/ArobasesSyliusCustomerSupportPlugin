<?php

namespace Arobases\SyliusCustomerSupportPlugin\EmailManager;


use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class SendNotificationAnswerEmailManager implements SendNotificationAnswerEmailManagerInterface
{

    /** @var SenderInterface */
    private $emailSender;


    public function __construct(SenderInterface $emailSender)
    {
        $this->emailSender = $emailSender;
    }


    public function sendNotificationAnswer(string $email, CustomerSupportAnswer $customerSupportAnswer, ChannelInterface $channel): void
    {
        $localeCode = $customerSupportAnswer->getCustomerSupport()->getOrder()->getLocaleCode();
        $this->emailSender->send('arobases_sylius_customer_support_plugin_answer_notification', [$email], [ 'localeCode' => $localeCode, 'customerSupportAnswer' => $customerSupportAnswer, 'channel' => $channel ]);
    }

}
