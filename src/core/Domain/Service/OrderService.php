<?php


namespace RestoOrder\Domain\Service;

use RestoOrder\UseCase\AllOrders\AllOrdersResponse;
use RestoOrder\UseCase\AllOrders\AllOrdersUseCaseInterface;
use RestoOrder\UseCase\CreateOrder\CreateOrderRequest;
use RestoOrder\UseCase\CreateOrder\CreateOrderResponse;
use RestoOrder\UseCase\CreateOrder\CreateOrderUseCaseInterface;
use RestoOrder\UseCase\FindOrder\FindOrderResponse;
use RestoOrder\UseCase\FindOrder\FindOrderUseCaseInterface;
use RestoOrder\UseCase\GenerateReceipt\GenerateReceiptResponse;
use RestoOrder\UseCase\GenerateReceipt\GenerateReceiptUseCaseInterface;

class OrderService
{


    protected $createOrderUc;
    protected $findOrderUc;
    protected $generateReceiptUc;
    protected $allOrdersUc;

    public function __construct(CreateOrderUseCaseInterface $co, FindOrderUseCaseInterface $fo, GenerateReceiptUseCaseInterface $gr, AllOrdersUseCaseInterface $ao)
    {

        $this->createOrderUc = $co;
        $this->findOrderUc = $fo;
        $this->generateReceiptUc = $gr;
        $this->allOrdersUc = $ao;
    }

    public function createOrder($postData): CreateOrderResponse
    {
        $createdOrderRequest = new CreateOrderRequest($postData['foods'], $postData['customer'], trim($postData['coupon']));
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