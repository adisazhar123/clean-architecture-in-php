<?php


namespace RestoOrder\Persistence\Doctrine\Repository;

use Doctrine\ORM\Query\Expr\Join;
use RestoOrder\Domain\Repository\OrderRepositoryInterface;

class OrderRepository extends AbstractDoctrineRepository implements OrderRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Order';

    public function allOrders()
    {
        $orders = $this->getAll();
        return $orders;
    }

    public function addOrder($order)
    {
        $order = $this->persist($order);
        return $order;
    }

    public function findOrder($id)
    {
        $order = $this->getById($id);
        return $order;
    }
}