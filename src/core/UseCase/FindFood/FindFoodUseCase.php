<?php


namespace RestoOrder\UseCase\FindFood;


use RestoOrder\Domain\Repository\FoodRepositoryInterface;

class FindFoodUseCase implements FindFoodUseCaseInterface
{
    protected $foodRepo;

    public function __construct(FoodRepositoryInterface $fr)
    {
        $this->foodRepo = $fr;
    }

    public function findFood($foodId): FindFoodResponse
    {
        $food = $this->foodRepo->getById($foodId);
        return new FindFoodResponse($food->getName(), $food->getDescription(), $food->getPrice());
    }
}