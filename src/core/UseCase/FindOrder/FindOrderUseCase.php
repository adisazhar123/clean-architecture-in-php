<?php


namespace RestoOrder\UseCase\FindOrder;


use RestoOrder\Domain\Repository\OrderRepositoryInterface;

class FindOrderUseCase
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function findOrder($id) : FindOrderResponse
    {
        $order = $this->orderRepository->getById($id);
        $findOrderResponse = new FindOrderResponse($order);
        return $findOrderResponse;
    }
}