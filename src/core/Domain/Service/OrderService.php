<?php


namespace RestoOrder\Domain\Service;

use RestoOrder\Domain\Repository\FoodRepositoryInterface;
use RestoOrder\Domain\Repository\OrderRepositoryInterface;
use RestoOrder\Domain\Repository\CustomerRepositoryInterface;

class OrderService
{
    protected $foodRepository;
    protected $orderRespository;
    protected $customerRepository;

    public function __construct(OrderRepositoryInterface $orderRepository, CustomerRepositoryInterface $customerRepository,
        FoodRepositoryInterface $foodRepository)
    {
        $this->orderRespository = $orderRepository;  
        $this->customerRepository = $customerRepository;      
        $this->foodRepository = $foodRepository;
    }

    public function createOrder($customer, $food)
    {
        // $this->customerRepository->persist($)
    }
}