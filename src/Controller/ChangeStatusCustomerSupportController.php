<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Controller;

use Arobases\SyliusCustomerSupportPlugin\Entity\CustomerSupport;
use Arobases\SyliusCustomerSupportPlugin\Repository\CustomerSupportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Sylius\Component\Core\Model\CustomerInterface;
use Sylius\Component\Customer\Context\CustomerContextInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

final class ChangeStatusCustomerSupportController
{
    private CustomerSupportRepository $customerSupportRepository;
    private RouterInterface $router;
    private EntityManagerInterface $manager;
    private CsrfTokenManagerInterface $csrfTokenManager;
    private CustomerContextInterface $customerContext;

    public function __construct(
        CustomerSupportRepository $customerSupportRepository,
        RouterInterface $router,
        EntityManagerInterface $manager,
        CsrfTokenManagerInterface $csrfTokenManager,
        CustomerContextInterface $customerContext,
    ) {
        $this->customerSupportRepository = $customerSupportRepository;
        $this->router = $router;
        $this->manager = $manager;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->customerContext = $customerContext;
    }

    public function changeStatus(Request $request): RedirectResponse
    {
        $customerSupportId = (string) $request->attributes->get('id');

        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken($customerSupportId, (string) $request->request->get('_csrf_token')))) {
            throw new AccessDeniedHttpException('Invalid CSRF token.');
        }

        /** @var CustomerSupport|null $customerSupport */
        $customerSupport = $this->findCustomerSupport($request, $customerSupportId);
        if (null === $customerSupport) {
            throw new NotFoundHttpException();
        }

        $customerSupport->setEnabled(!$customerSupport->isEnabled());
        $this->manager->flush();

        $redirectRoute = $this->getSyliusAttribute($request, 'redirect', 'referer');

        return new RedirectResponse($this->router->generate($redirectRoute));
    }

    private function findCustomerSupport(Request $request, string $customerSupportId): ?CustomerSupport
    {
        // In the shop, a customer can only open or close his own tickets
        if ('shop_account' === $this->getSyliusAttribute($request, 'section', null)) {
            $customer = $this->customerContext->getCustomer();
            if (!$customer instanceof CustomerInterface) {
                return null;
            }

            return $this->customerSupportRepository->findOneByIdAndCustomer($customerSupportId, $customer);
        }

        return $this->customerSupportRepository->find($customerSupportId);
    }

    private function getSyliusAttribute(Request $request, string $attributeName, ?string $default): ?string
    {
        $attributes = $request->attributes->get('_sylius');

        return $attributes[$attributeName] ?? $default;
    }
}
