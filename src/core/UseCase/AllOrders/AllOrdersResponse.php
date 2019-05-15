<?php


namespace RestoOrder\UseCase\AllOrders;


use RestoOrder\Helpers\CurrencyTrait;

class AllOrdersResponse
{
    use CurrencyTrait;

    protected $orders = [];

    public function __construct(array $orders)
    {
        $this->map($orders);
    }

    public function map(array $orders)
    {
        foreach ($orders as $order)
        {
            $this->orders [] = ['order_id' => $order->getId(), 'customer' => $order->getCustomer()->getName(), 'description' => $order->getDescription(),
                'price' => $order->getTotal()];
        }

    }

    public function formatOrderId($orderId)
    {
        return 'ADISRESTO-' . $orderId;
    }

    public function getOrders()
    {
        return $this->orders;
    }
}