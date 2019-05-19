<?php


namespace RestoOrder\UseCase\UpdateFood;


use RestoOrder\Domain\Repository\FoodRepositoryInterface;

class UpdateFoodUseCase implements UpdateFoodUseCaseInterface
{
    protected $foodRepo;

    public function __construct(FoodRepositoryInterface $fr)
    {
        $this->foodRepo = $fr;
    }

    public function updateFood($foodId, UpdateFoodRequest $request): UpdateFoodResponse
    {
        $food = $this->foodRepo->findFood($foodId);
        $food->setName($request->getName());
        $food->setDescription($request->getDescription());
        $food->setPrice($request->getPrice());
        $updatedFood = $this->foodRepo->addFood($food);
        return new UpdateFoodResponse($updatedFood);
    }
}