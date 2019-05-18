<?php


namespace RestoOrder\Persistence\Doctrine\Repository;

use Doctrine\ORM\Query\Expr\Join;
use RestoOrder\Domain\Repository\OrderRepositoryInterface;

class OrderRepository extends AbstractDoctrineRepository implements OrderRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Order';



    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }

}