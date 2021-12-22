<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Form\Shop;

use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupport;
use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswer;
use Sylius\Bundle\CoreBundle\Form\Type\AddressChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

final class CustomerSupportCreateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('order', OrderChoiceType::class, [
                'label' => 'sylius.ui.order'
            ])
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
        $data->setCustomer($data->getOrder()->getCustomer());


    }
    public function getBlockPrefix(): string
    {
        return 'arobases_customer_support_create';
    }

}
