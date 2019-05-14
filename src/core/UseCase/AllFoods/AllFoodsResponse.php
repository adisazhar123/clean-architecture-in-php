<?php


namespace RestoOrder\UseCase\AllFoods;


use RestoOrder\Domain\Entity\Food;

class AllFoodsResponse
{
    protected $foods = [];

    public function __construct(array $foods)
    {
        $this->map($foods);
    }

    /**
     * @param array $foods
     */
    public function map(array $foods)
    {
        foreach ($foods as $food)
        {
            $this->foods [] = ['food_id' => $food->getId(), 'name' => $food->getName(), 'description' => $food->getDescription(),
                'price' => $food->getPrice()];
        }
    }

    public function formatToRupiah($price)
    {
        return number_format($price,2,',','.');
    }

    /**
     * @return array
     */
    public function getFoods(): array
    {
        return $this->foods;
    }
}