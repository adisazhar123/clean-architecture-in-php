<?php


namespace RestoOrder\Domain\Service;

use RestoOrder\Domain\Entity\Order;
use RestoOrder\Domain\Entity\Customer;
use RestoOrder\Domain\Entity\FoodOrder;
use RestoOrder\UseCase\AllOrders\AllOrdersResponse;
use RestoOrder\UseCase\AllOrders\AllOrdersUseCase;
use RestoOrder\UseCase\CreateOrder\CreateOrderRequest;
use RestoOrder\UseCase\CreateOrder\CreateOrderUseCase;
use RestoOrder\UseCase\CreateOrder\CreateOrderResponse;
use RestoOrder\Domain\Repository\FoodRepositoryInterface;
use RestoOrder\Domain\Repository\OrderRepositoryInterface;
use RestoOrder\Domain\Repository\CustomerRepositoryInterface;
use RestoOrder\Domain\Repository\FoodOrderRepositoryInterface;
use RestoOrder\UseCase\FindOrder\FindOrderResponse;
use RestoOrder\UseCase\FindOrder\FindOrderUseCase;
use RestoOrder\UseCase\GenerateReceipt\GenerateReceiptResponse;
use RestoOrder\UseCase\GenerateReceipt\GenerateReceiptUseCase;

class OrderService
{

    protected $customerRepository;
    protected $foodRepository;
    protected $orderRepository;
    protected $foodOrderRepository;

    protected $createOrderUc;
    protected $findOrderUc;
    protected $generateReceiptUc;
    protected $allOrdersUc;

    public function __construct(CustomerRepositoryInterface $customerRepository, FoodRepositoryInterface $foodRepository, OrderRepositoryInterface $orderRepository,            FoodOrderRepositoryInterface $foodOrderRepository, CreateOrderUseCase $co, FindOrderUseCase $fo, GenerateReceiptUseCase $gr, AllOrdersUseCase $ao)
    {
        $this->customerRepository = $customerRepository;
        $this->foodRepository = $foodRepository;
        $this->orderRepository = $orderRepository;
        $this->foodOrderRepository = $foodOrderRepository;

        $this->createOrderUc = $co;
        $this->findOrderUc = $fo;
        $this->generateReceiptUc = $gr;
        $this->allOrdersUc = $ao;
    }

    public function createOrder($postData): CreateOrderResponse
    {
        $createdOrderRequest = new CreateOrderRequest($postData['foods'], $postData['customer']);
        $createdOrder = $this->createOrderUc->createOrder($createdOrderRequest);
        return $createdOrder;
    }

    public function findOrder($id) : FindOrderResponse
    {
        $order = $this->findOrderUc->findOrder($id);
        return $order;
    }

    public function generateReceipt($orderId): GenerateReceiptResponse
    {
        return $this->generateReceiptUc->generateReceipt($orderId);
    }

    public function allOrder(): AllOrdersResponse
    {
        return $this->allOrdersUc->allOrders();
    }
}