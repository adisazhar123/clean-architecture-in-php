<?php


namespace RestoOrder\Persistence\Doctrine\Repository;


use RestoOrder\Domain\Entity\Food;
use RestoOrder\Domain\Repository\FoodRepositoryInterface;

class FoodRepository extends AbstractDoctrineRepository implements FoodRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Food';

    public function addFood($food)
    {
        $food = $this->persist($food);
        return $food;
    }

    public function allFoods()
    {
        $foods = $this->getAll();
        return $foods;
    }

    public function findFood($id)
    {
        $food = $this->getById($id);
        return $food;
    }
}