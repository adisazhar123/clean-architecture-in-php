<?php


namespace RestoOrder\Domain\Repository;


interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getUninvoicedOrders();
}