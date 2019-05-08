<?php


namespace RestoOrder\Persistence\Doctrine\Repository;


use RestoOrder\Domain\Repository\FoodRepositoryInterface;

class FoodRepository extends AbstractDoctrineRepository implements FoodRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Food';
}