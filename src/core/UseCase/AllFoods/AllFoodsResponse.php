<?php


namespace RestoOrder\UseCase\AllFoods;


use RestoOrder\Domain\Entity\Food;
use RestoOrder\Helpers\CurrencyTrait;

class AllFoodsResponse
{
    use CurrencyTrait;

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


    /**
     * @return array
     */
    public function getFoods(): array
    {
        return $this->foods;
    }
}