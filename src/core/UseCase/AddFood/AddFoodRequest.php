<?php


namespace RestoOrder\UseCase\AddFood;


class AddFoodRequest
{
    protected $name;
    protected $description;
    protected $price;

    /**
     * AddFoodRequest constructor.
     * @param $foodRequest
     */
    public function __construct($foodRequest)
    {
        $this->name = $foodRequest['name'];
        $this->description = $foodRequest['description'];
        $this->price = $foodRequest['price'];
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param mixed $price
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }
}