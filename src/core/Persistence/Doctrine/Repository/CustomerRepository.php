<?php


namespace RestoOrder\Persistence\Doctrine\Repository;

use RestoOrder\Domain\Repository\CustomerRepositoryInterface;

class CustomerRepository extends AbstractDoctrineRepository implements CustomerRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Customer';

    public function addCustomer($customer)
    {
        $customer = $this->persist($customer);
        return $customer;
    }

}