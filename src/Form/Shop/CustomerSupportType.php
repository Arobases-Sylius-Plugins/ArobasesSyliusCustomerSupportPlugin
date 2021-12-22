<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Form\Shop;


use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupport;
use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Sylius\Component\Customer\Model\Customer;
use Sylius\Component\Order\Model\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class CustomerSupportType extends AbstractType
{
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
        $message = $form->get('customerSupportAnswers')->getData()['message'];

        $customerSupportAnswer = new CustomerSupportAnswer();
        $customerSupportAnswer->setMessage($message);
        $customerSupportAnswer->setCustomerSupport($data);
        $customerSupportAnswer->setAuthor($data->getOrder()->getCustomer()->getFullName());

        $data->addCustomerSupportAnswer($customerSupportAnswer);


    }
    public function getBlockPrefix(): string
    {
        return 'arobases_customer_support';
    }

}
