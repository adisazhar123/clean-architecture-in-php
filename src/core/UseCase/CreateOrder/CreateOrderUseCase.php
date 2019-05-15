<?php

namespace RestoOrder\UseCase\CreateOrder;

use RestoOrder\Domain\Entity\Order;
use RestoOrder\Domain\Entity\Customer;
use RestoOrder\Domain\Entity\FoodOrder;
use RestoOrder\UseCase\CreateOrder\CreateOrderResponse;
use RestoOrder\Domain\Repository\FoodRepositoryInterface;
use RestoOrder\Domain\Repository\OrderRepositoryInterface;
use RestoOrder\Domain\Repository\CustomerRepositoryInterface;
use RestoOrder\Domain\Repository\FoodOrderRepositoryInterface;

class CreateOrderUseCase implements CreateOrderUseCaseInterface
{
    protected $customerRepository;
    protected $foodRepository;
    protected $orderRepository;
    protected $foodOrderRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository, FoodRepositoryInterface $foodRepository, OrderRepositoryInterface $orderRepository, FoodOrderRepositoryInterface $foodOrderRepository)
    {
        $this->customerRepository = $customerRepository;
        $this->foodRepository = $foodRepository;
        $this->orderRepository = $orderRepository;
        $this->foodOrderRepository = $foodOrderRepository;   
    }

    public function createOrder(CreateOrderRequest $request) : CreateOrderResponse
    {
        $foods = $request->getFoods();
        $cus = $request->getCustomer();

//        error_log(count($foods), 3, '/home/adisazhar/projects/phalcon/clean-arch/src/core/UseCase/CreateOrder/phalcon.log');
        try {
            $customer = new Customer();
            $customer->setName($cus['name']);
            $customer->setPhone($cus['phone']);
            $this->customerRepository->persist($customer);        
            
            $total_price = 0;

            foreach($foods as $food) {   
                // calculate total price
                $food_total = doubleval($food['amount']) * doubleval($food['price']);
//                error_log($food['name'] . ': ' . $food['amount'] . " * " . $food['price'] . "\n", 3, '/home/adisazhar/projects/phalcon/clean-arch/src/core/UseCase/CreateOrder/phalcon.log');
//                error_log(doubleval($food['amount']) * doubleval($food['price']) . "\n", 3, '/home/adisazhar/projects/phalcon/clean-arch/src/core/UseCase/CreateOrder/phalcon.log');
                $total_price += $food_total;
            }
            
            $order = new Order();
            $order->setCustomer($customer);
            $order->setDescription($cus['description']);
            $order->setTotal($total_price);
            $order->setOrderNumber('ADIS' . time());
            $order = $this->orderRepository->persist($order);
            

            foreach($foods as $food) {
                // find Food entity from DB
                $f = $this->foodRepository->getById($food['id']);

                for($i=0; $i < $food['amount']; $i++) {
                    
                    $fo = new FoodOrder();
                    $fo->setFood($f);
                    $fo->setOrder($order);
                    $this->foodOrderRepository->persist($fo);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return new CreateOrderResponse($e->getMessage(), 'Internal Server Error' ,$e->getCode());
        }

        return new CreateOrderResponse("Order created.", "Created", 201);
    }
}