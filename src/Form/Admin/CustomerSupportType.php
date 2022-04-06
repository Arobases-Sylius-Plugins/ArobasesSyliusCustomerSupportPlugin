<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Form\Admin;

use Arobases\SyliusCustomerSupportPlugin\EmailManager\SendNotificationAnswerEmailManager;
use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupport;
use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Arobases\SyliusCustomerSupportPlugin\Files\Uploader\CustomerSupportAnswerUploader;
use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Resource\ResourceActions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class CustomerSupportType extends AbstractType
{
    private CustomerSupportAnswerUploader $customerSupportAnswerUploader;
    private SendNotificationAnswerEmailManager $sendNotificationAnswerEmailManager;


    public function __construct(CustomerSupportAnswerUploader $customerSupportAnswerUploader, SendNotificationAnswerEmailManager $sendNotificationAnswerEmailManager)
    {
        $this->customerSupportAnswerUploader = $customerSupportAnswerUploader;
        $this->sendNotificationAnswerEmailManager = $sendNotificationAnswerEmailManager;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('customerSupportAnswers', CustomerSupportAnswerType::class, [
                'mapped' => false,
                 'label' => 'arobases_sylius_customer_support.ui.new_message',
                 'required' => false,
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, [$this, 'onPostSubmit']);
    }

    public function onPostSubmit(FormEvent $event): void
    {
        /** @var CustomerSupport $data */
        $data = $event->getData();
        $form = $event->getForm();
        $file = null;
        $message = $form->get('customerSupportAnswers')->getData()['message'];
        if(array_key_exists('file',$form->get('customerSupportAnswers')->getData() ))
            $file = $form->get('customerSupportAnswers')->getData()['file'];
        $customerSupportAnswer = new CustomerSupportAnswer();
        $customerSupportAnswer->setMessage($message);
        $customerSupportAnswer->setCustomerSupport($data);
        $customerSupportAnswer->setAuthor('admin');
        if ($file !== null) {
            $pathFile = $this->customerSupportAnswerUploader->upload($file);
            $customerSupportAnswer->setFilePath($pathFile);
        }

        $data->addCustomerSupportAnswer($customerSupportAnswer);
        $mailCustomer = $data->getCustomer()->getEmail();
        if($mailCustomer !== null){
            $this->sendNotificationAnswerEmailManager->sendNotificationAnswer($mailCustomer, $customerSupportAnswer, $data->getOrder()->getChannel() );

        }

    }
    public function getBlockPrefix(): string
    {
        return 'arobases_customer_support';
    }

}
