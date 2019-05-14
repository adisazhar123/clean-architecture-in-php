<?php
namespace RestoOrder\UseCase\CreateOrder;

class CreateOrderRequest {
    protected $foods;
    protected $customer;

    /**
     * CreateOrderRequest constructor.
     * @param $foods
     * @param $customer
     */
    public function __construct($foods, $customer)
    {
        $this->foods = $foods;
        $this->customer = $customer;
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
        $this->foods = $foods;
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