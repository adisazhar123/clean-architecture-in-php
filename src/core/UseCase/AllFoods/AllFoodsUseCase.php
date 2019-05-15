<?php


namespace RestoOrder\UseCase\AllFoods;


use RestoOrder\Domain\Repository\FoodRepositoryInterface;

class AllFoodsUseCase implements AllFoodsUseCaseInterface
{
    protected $foodRepository;

    public function __construct(FoodRepositoryInterface $foodRepository)
    {
        $this->foodRepository = $foodRepository;
    }

    public function allFoods() : AllFoodsResponse
    {
        $foods = $this->foodRepository->getAll();
        $foodResponse = new AllFoodsResponse($foods);
        return $foodResponse;
    }
}