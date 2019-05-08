<?php


namespace RestoOrder\Domain\Entity;


class FoodOrder extends AbstractEntity
{
    protected $order;
    protected $food;

  
    public function setOrder($order)
    {
        $this->order = $order;
    }

    public function getOrder()
    {
        return $this->order;
    }

    public function setFood($food)
    {
        $this->food = $food;
    }

    public function getFood()
    {
        return $this->food;
    } 


}