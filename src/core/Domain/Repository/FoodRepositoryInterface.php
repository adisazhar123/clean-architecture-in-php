<?php


namespace RestoOrder\Domain\Repository;


interface FoodRepositoryInterface
{
    public function addFood($food);
    public function allFoods();
    public function findFood($id);
}