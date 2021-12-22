<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Form\Shop;

use Sylius\Bundle\ApiBundle\Context\UserContextInterface;
use Sylius\Component\Core\Repository\AddressRepositoryInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class OrderChoiceType extends AbstractType
{

    private OrderRepositoryInterface $orderRepository;
    private CustomerContextInterface $customerContext;

    public function __construct(OrderRepositoryInterface $orderRepository, CustomerContextInterface $customerContext)
    {
        $this->orderRepository = $orderRepository;
        $this->customerContext = $customerContext;
    }


    public function configureOptions(OptionsResolver $resolver): void
    {

        $resolver->setDefaults([
            'choices' => function (Options $options): array {
                return $this->orderRepository->findByCustomer($this->customerContext->getCustomer());
            },
            'choice_value' => 'id',
            'choice_label' => 'number',
            'placeholder' => false,
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_address_choice';
    }
}
