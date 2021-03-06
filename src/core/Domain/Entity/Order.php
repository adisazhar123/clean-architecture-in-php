<?php


namespace RestoOrder\Domain\Entity;

use RestoOrder\Domain\Entity\Food;


class Order extends AbstractEntity
{
    protected $customer;
    protected $orderNumber;
    protected $description;
    protected $total;
    protected $foods;
    // protected $food

    public function __construct()
    {
        $this->foods = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function addFood(Food $food)
    {
        $this->foods[] = $food;
        $food->addOrder($this);
        return $this;
    }

    public function getFoods()
    {
        return $this->foods;
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

    /**
     * @return mixed
     */
    public function getOrderNumber()
    {
        return $this->orderNumber;
    }

    /**
     * @param mixed $orderNumber
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * @param mixed $total
     */
    public function setTotal($total)
    {
        $this->total = $total;
    }
}