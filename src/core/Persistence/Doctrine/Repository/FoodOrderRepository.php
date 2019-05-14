<?php

namespace RestoOrder\Persistence\Doctrine\Repository;

use RestoOrder\Domain\Repository\InvoiceRepositoryInterface;
use RestoOrder\Domain\Repository\FoodOrderRepositoryInterface;

class FoodOrderRepository extends AbstractDoctrineRepository implements FoodOrderRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\FoodOrder';
}