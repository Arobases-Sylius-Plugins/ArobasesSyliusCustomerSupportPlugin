<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Form\Admin;


use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupportAnswers;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Customer\Model\Customer;
use Sylius\Component\Order\Model\Order;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;

final class CustomerSupportType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
//        $builder
//
//            ->add('customer', EntityType::class, [
//                'class' => Customer::class,
//                'choice_label' => 'email',
//                'attr' => ['disabled' => 'disabled'],
//                'constraints' => [
//                    new NotBlank([
//                        'message' => 'sylius.contact.message.not_blank',
//                    ]),
//                ],
//            ])
//            ->add('order', EntityType::class, [
//                'class' => Order::class,
//                'required' => false,
//                'choice_label' => 'id'
//            ]);


    }

}
