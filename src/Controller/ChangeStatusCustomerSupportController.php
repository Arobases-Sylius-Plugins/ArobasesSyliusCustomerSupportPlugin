<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Controller;

use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupport;
use Arobases\SyliusCustomerSupportPlugin\Repository\CustomerSupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Setono\SyliusMailchimpPlugin\Repository\OrderRepositoryInterface;
use SM\Factory\FactoryInterface;
use Sylius\Component\Order\OrderTransitions;
use Sylius\Component\Resource\Repository\RepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;

final class ChangeStatusCustomerSupportController
{
    private RepositoryInterface $customerSupportRepository;
    private RouterInterface $router;
    private EntityManagerInterface $manager;

    public function __construct(RepositoryInterface $customerSupportRepository, RouterInterface $router, EntityManagerInterface $manager)
    {
        $this->customerSupportRepository = $customerSupportRepository;
        $this->router = $router;
        $this->manager = $manager;
    }


    public function changeStatus(Request $request)
    {
        $customerSupportId = $request->attributes->get('id');
        /** @var CustomerSupport $customerSupport */
        $customerSupport =  $this->customerSupportRepository->find($customerSupportId);
        if($customerSupport->isEnabled()){
            $customerSupport->setEnabled(false);
        }else{
            $customerSupport->setEnabled(true);
        }
        $this->manager->persist($customerSupport);
        $this->manager->flush();
        $redirectRoute = $this->getSyliusAttribute($request, 'redirect', 'referer');
        return new RedirectResponse($this->router->generate($redirectRoute));
    }

    private function getSyliusAttribute(Request $request, string $attributeName, ?string $default): ?string
    {
        $attributes = $request->attributes->get('_sylius');

        return $attributes[$attributeName] ?? $default;
    }
}
