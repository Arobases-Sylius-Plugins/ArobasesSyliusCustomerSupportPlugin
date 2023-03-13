<?php

namespace Arobases\SyliusCustomerSupportPlugin\EmailManager;



use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Locale\Context\LocaleContextInterface;
use Sylius\Component\Mailer\Model\Email;
use Sylius\Component\Mailer\Provider\EmailProviderInterface;
use Sylius\Component\Mailer\Sender\SenderInterface;

final class SendNotificationAnswerEmailManager
{

    /** @var SenderInterface */
    private $emailSender;

    private LocaleContextInterface $localeContext;

    /**
     * SendNotificationAnswerEmailManager constructor.
     * @param SenderInterface $emailSender
     * @param LocaleContextInterface $localeContext
     */
    public function __construct(SenderInterface $emailSender, LocaleContextInterface $localeContext)
    {
        $this->emailSender = $emailSender;
        $this->localeContext = $localeContext;
    }


    public function sendNotificationAnswer(string $email, CustomerSupportAnswer $customerSupportAnswer, ChannelInterface $channel): void
    {
        $localeCode = $this->localeContext->getLocaleCode();
        $this->emailSender->send('arobases_sylius_customer_support_plugin_answer_notification', [$email], [ 'localeCode' => $localeCode, 'customerSupportAnswer' => $customerSupportAnswer, 'channel' => $channel ]);
    }

}
