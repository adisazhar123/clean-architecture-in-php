<?php


namespace RestoOrder\UseCase\UpdateFood;


use RestoOrder\Domain\Entity\Food;

class UpdateFoodResponse
{
    protected $name;
    protected $description;
    protected $price;

    public function __construct(Food $food)
    {
        $this->name = $food->getName();
        $this->description = $food->getDescription();
        $this->price = $food->getPrice();
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