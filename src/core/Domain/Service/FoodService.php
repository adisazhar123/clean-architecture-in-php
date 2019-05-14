<?php


namespace RestoOrder\Domain\Service;

use RestoOrder\Domain\Repository\FoodRepositoryInterface;
use RestoOrder\UseCase\AddFood\AddFoodRequest;
use RestoOrder\UseCase\AddFood\AddFoodResponse;
use RestoOrder\UseCase\AddFood\AddFoodUseCase;
use RestoOrder\UseCase\AddFood\AddFoodUseCaseInterface;
use RestoOrder\UseCase\AllFoods\AllFoodsResponse;
use RestoOrder\UseCase\AllFoods\AllFoodsUseCase;
use RestoOrder\UseCase\FindFood\FindFoodResponse;
use RestoOrder\UseCase\FindFood\FindFoodUseCase;
use RestoOrder\UseCase\UpdateFood\UpdateFoodRequest;
use RestoOrder\UseCase\UpdateFood\UpdateFoodResponse;
use RestoOrder\UseCase\UpdateFood\UpdateFoodUseCase;


class FoodService
{
    protected $foodRepository;

    protected $allFoodsUc;
    protected $addFoodUc;
    protected $findFoodUc;
    protected $updateFoodUc;

    public function __construct(FoodRepositoryInterface $foodRepository, AllFoodsUseCase $af, AddFoodUseCaseInterface $adf, FindFoodUseCase $ff, UpdateFoodUseCase $uf)
    {
        $this->foodRepository = $foodRepository;
        $this->allFoodsUc = $af;
        $this->addFoodUc = $adf;
        $this->findFoodUc = $ff;
        $this->updateFoodUc = $uf;
    }

    public function getAvailableFoods(): AllFoodsResponse
    {
        return $this->allFoodsUc->allFoods();
    }

    public function addFood($foodRequest): AddFoodResponse
    {
        $addFoodRequest = new AddFoodRequest($foodRequest);
        return $this->addFoodUc->addFood($addFoodRequest);
    }

    public function findFood($foodId): FindFoodResponse
    {
        return $this->findFoodUc->findFood($foodId);
    }

    public function updateFood($foodId, $postRequest): UpdateFoodResponse
    {
        $foodRequest = new UpdateFoodRequest($postRequest);
        return $this->updateFoodUc->updateFood($foodId, $foodRequest);
    }
}