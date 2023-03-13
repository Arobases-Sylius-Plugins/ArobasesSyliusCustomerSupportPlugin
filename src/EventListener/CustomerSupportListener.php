<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\EventListener;

use Arobases\SyliusCustomerSupportPlugin\EmailManager\SendNotificationAnswerEmailManager;
use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ChannelInterface;

final class CustomerSupportListener
{
    private SendNotificationAnswerEmailManager $sendNotificationAnswerEmailManager;

    public function __construct(SendNotificationAnswerEmailManager $sendNotificationAnswerEmailManager)
    {
        $this->sendNotificationAnswerEmailManager = $sendNotificationAnswerEmailManager;
    }

    public function postUpdate(ResourceControllerEvent $event){
        $customerSupportAnswer = $event->getSubject()->getCustomerSupportAnswers()->last();
        if($customerSupportAnswer->getAuthor() === "admin" ) {
            $mailCustomer = $event->getSubject()->getCustomer()->getEmail();
            if($mailCustomer !== null){
                $this->sendEmail($mailCustomer, $customerSupportAnswer,  $event->getSubject()->getOrder()->getChannel());
            }
        }else{
            $mailChannel = $event->getSubject()->getOrder()->getChannel()->getContactEmail();
            if($mailChannel !== null){
                $this->sendEmail($mailChannel, $customerSupportAnswer,  $event->getSubject()->getOrder()->getChannel());
            }
        }
    }
    public function postCreate(ResourceControllerEvent $event){
        $customerSupportAnswer = $event->getSubject()->getCustomerSupportAnswers()->last();
        $mailChannel = $event->getSubject()->getOrder()->getChannel()->getContactEmail();

        if($mailChannel !== null){
            $this->sendEmail($mailChannel, $customerSupportAnswer,  $event->getSubject()->getOrder()->getChannel());
        }
    }

    protected function sendEmail(string $email, CustomerSupportAnswer $customerSupportAnswer, ChannelInterface $channel){
        $this->sendNotificationAnswerEmailManager->sendNotificationAnswer($email, $customerSupportAnswer, $channel);
    }
}
