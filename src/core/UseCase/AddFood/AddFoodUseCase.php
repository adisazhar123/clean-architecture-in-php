<?php


namespace RestoOrder\UseCase\AddFood;


use RestoOrder\Domain\Entity\Food;
use RestoOrder\Domain\Repository\FoodRepositoryInterface;

class AddFoodUseCase implements AddFoodUseCaseInterface
{
    protected $foodRepository;
    public function __construct(FoodRepositoryInterface $fr)
    {
        $this->foodRepository = $fr;
    }

    public function addFood(AddFoodRequest $request): AddFoodResponse
    {
        $food = new Food();
        $food->setName($request->getName());
        $food->setDescription($request->getDescription());
        $food->setPrice($request->getPrice());

        $addedFood = $this->foodRepository->persist($food);
        return new AddFoodResponse($addedFood->getName(), $addedFood->getDescription(), $addedFood->getPrice());

    }
}