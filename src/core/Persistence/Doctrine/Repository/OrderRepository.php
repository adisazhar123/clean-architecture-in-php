<?php


namespace RestoOrder\Persistence\Doctrine\Repository;

use Doctrine\ORM\Query\Expr\Join;
use RestoOrder\Domain\Repository\OrderRepositoryInterface;

class OrderRepository extends AbstractDoctrineRepository implements OrderRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Order';

    public function getUninvoicedOrders()
    {
        $builder = $this->entityManager->createQueryBuilder()
            ->select('o')
            ->from($this->entityClass, 'o')
            ->leftJoin(
                'RestoOrder\Domain\Entity\Invoice',
                'i',
                Join::WITH,
                'i.order = 0'
            )
            ->where('i.id IS NULL');

        return $builder->getQuery()->getResult();
    }

    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }

}