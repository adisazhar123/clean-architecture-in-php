<?php


namespace RestoOrder\UseCase\AllOrders;


use RestoOrder\Domain\Repository\OrderRepositoryInterface;

class AllOrdersUseCase
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function allOrders(): AllOrdersResponse
    {
        $orders = $this->orderRepository->getAll();
        $ordersResponse = new AllOrdersResponse($orders);
        return $ordersResponse;
    }
}