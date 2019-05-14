<?php


namespace RestoOrder\Persistence\Doctrine\Repository;


use RestoOrder\Domain\Repository\FoodRepositoryInterface;

class FoodRepository extends AbstractDoctrineRepository implements FoodRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Food';

    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $entity;
    }
}