<?php

declare(strict_types=1);

namespace Arobases\SyliusCustomerSupportPlugin\Repository;

use Sylius\Bundle\ResourceBundle\Doctrine\ORM\EntityRepository;
use Sylius\Component\Core\Model\CustomerInterface;

final class CustomerSupportRepository extends EntityRepository
{
    public function findOneByIdAndCustomer(string $id, CustomerInterface $customer)
    {
        return $this->createQueryBuilder('customer_support')
            ->where('customer_support.customer = :customer')
            ->andWhere('customer_support.id = :id')
            ->setParameter('customer', $customer)
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult()
            ;
    }
}
