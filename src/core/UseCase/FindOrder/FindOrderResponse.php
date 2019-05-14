<?php


namespace RestoOrder\UseCase\FindOrder;


use RestoOrder\Domain\Entity\Order;

class FindOrderResponse
{
    protected $order = [];
    protected $foods = [];

    /**
     * FindOrderResponse constructor.
     * @param $order
     * @param $foods
     */
    public function __construct(Order $order)
    {
        $this->map($order);
    }

    /**
     * @param Order $order
     */
    public function map(Order $order)
    {
        $this->order = ['order_id' => $order->getId(), 'customer' => $order->getCustomer()->getName()];
        foreach ($order->getFoods() as $orderFood) {
            $this->foods [] = ['name' => $orderFood->getFood()->getName(), 'description' => $orderFood->getFood()->getDescription(),
                'price' => $orderFood->getFood()->getPrice()];
        }
    }

    /**
     * @return array
     */
    public function getFoods(): array
    {
        return $this->foods;
    }

    /**
     * @return array
     */
    public function getOrder(): array
    {
        return $this->order;
    }


}