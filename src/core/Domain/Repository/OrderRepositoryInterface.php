<?php


namespace RestoOrder\Domain\Repository;


interface OrderRepositoryInterface
{
    public function allOrders();
    public function addOrder($order);
    public function findOrder($id);
}