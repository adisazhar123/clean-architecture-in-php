<?php


namespace RestoOrder\UseCase\FindOrder;


use RestoOrder\Domain\Entity\Order;

class FindOrderResponse
{
    protected $order = [];
    protected $foods = [];
    protected $coupon = [];

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
     * @return array
     */
    public function getCoupon(): array
    {
        return $this->coupon;
    }

    /**
     * @param Order $order
     */
    public function map(Order $order)
    {
        $this->order = ['order_id' => $order->getId(), 'customer' => $order->getCustomer()->getName(), 'total_price' => $order->getTotal()];
        $coupon = $order->getCoupon();
        $this->coupon = [$coupon];
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