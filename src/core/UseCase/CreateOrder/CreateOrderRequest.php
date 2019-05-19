<?php
namespace RestoOrder\UseCase\CreateOrder;

class CreateOrderRequest {
    protected $foods = [];
    protected $coupon;
    protected $customer;

    /**
     * CreateOrderRequest constructor.
     * @param $foods
     * @param $customer
     */
    public function __construct($foods, $customer, $coupon)
    {
        $this->foods = $foods;
        $this->customer = $customer;
        $this->coupon = $coupon;
    }

    /**
     * @return mixed
     */
    public function getCoupon()
    {
        return $this->coupon;
    }

    /**
     * @param mixed $coupon
     */
    public function setCoupon($coupon)
    {
        $this->coupon = $coupon;
    }

    /**
     * @return mixed
     */
    public function getFoods()
    {
        return $this->foods;
    }

    /**
     * @param mixed $foods
     */
    public function setFoods($foods)
    {
        $this->foods [] = $foods;
    }

    /**
     * @return mixed
     */
    public function getCustomer()
    {
        return $this->customer;
    }

    /**
     * @param mixed $customer
     */
    public function setCustomer($customer)
    {
        $this->customer = $customer;
    }

}