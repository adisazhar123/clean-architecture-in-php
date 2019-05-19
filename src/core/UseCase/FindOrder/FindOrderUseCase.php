<?php


namespace RestoOrder\UseCase\FindOrder;


use RestoOrder\Domain\Repository\OrderRepositoryInterface;

class FindOrderUseCase implements FindOrderUseCaseInterface
{
    protected $orderRepository;

    public function __construct(OrderRepositoryInterface $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function findOrder($id) : FindOrderResponse
    {
        $order = $this->orderRepository->findOrder($id);
        $findOrderResponse = new FindOrderResponse($order);
        return $findOrderResponse;
    }
}