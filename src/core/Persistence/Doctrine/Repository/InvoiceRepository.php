<?php

namespace RestoOrder\Persistence\Doctrine\Repository;

use RestoOrder\Domain\Repository\InvoiceRepositoryInterface;

class InvoiceRepository extends AbstractDoctrineRepository implements InvoiceRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Invoice';
}