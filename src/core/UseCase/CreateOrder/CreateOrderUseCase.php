<?php

namespace RestoOrder\UseCase\CreateOrder;

use RestoOrder\Domain\Entity\Order;
use RestoOrder\Domain\Entity\Customer;
use RestoOrder\Domain\Entity\FoodOrder;
use RestoOrder\Domain\Repository\CouponRepositoryInterface;
use RestoOrder\UseCase\CanUseDiscount\CanUseDiscountUseCase;
use RestoOrder\UseCase\CountTotalAfterDiscount\CountTotalAfterDiscountUseCase;
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
    protected $couponRepository;
    protected $countTotalAfterDiscountUc;
    protected $canUseDiscountUc;

    public function __construct(CustomerRepositoryInterface $customerRepository, FoodRepositoryInterface $foodRepository, OrderRepositoryInterface $orderRepository, FoodOrderRepositoryInterface $foodOrderRepository, CouponRepositoryInterface $couponRepository, CountTotalAfterDiscountUseCase $ctad, CanUseDiscountUseCase $cud)
    {
        $this->customerRepository = $customerRepository;
        $this->foodRepository = $foodRepository;
        $this->orderRepository = $orderRepository;
        $this->foodOrderRepository = $foodOrderRepository;
        $this->couponRepository = $couponRepository;
        $this->countTotalAfterDiscountUc = $ctad;
        $this->canUseDiscountUc = $cud;
    }

    public function createOrder(CreateOrderRequest $request) : CreateOrderResponse
    {
        $foods = $request->getFoods();
        $cus = $request->getCustomer();
        $coupon = $request->getCoupon();
        $discountAmount = 0; //default value

        try {
//            count total price
            $total_price = 0;
            foreach($foods as $food) {
                // calculate total price
                $food_total = doubleval($food['amount']) * doubleval($food['price']);
//                error_log("food price: " . doubleval($food['price']) . "\n", 3, "/home/adisazhar/Desktop/phalcon.log");
                $total_price += $food_total;
            }

//            check if using coupon
            if ($coupon)
            {
//                find the coupon
                $cpn = $this->couponRepository->findCoupon($coupon);
                if(!$cpn)
                {
                    return new CreateOrderResponse(['Coupon not found/ active'], 'Bad Request' , 400);
                }
                $discountAmount = $cpn[0]->getDiscountAmount();
                $minDate = $cpn[0]->getMinDate();
                $maxDate = $cpn[0]->getMaxDate();
                $minSpending = $cpn[0]->getMinSpending();
                $active = $cpn[0]->getActive();
                $currentDate = new \DateTime();
                $currentDate->setTime(0, 0, 0);

//                check can use coupon
                $canUse = $this->canUseDiscountUc->canUseDiscount($minSpending, $total_price, $minDate, $maxDate, $currentDate, $active);
//                cant use coupon
                if($canUse['code'] == 400) {
                    return new CreateOrderResponse($canUse['messages'], 'Bad Request' , 400);
                }
            }

            $customer = new Customer();
            $customer->setName($cus['name']);
            $customer->setPhone($cus['phone']);
            $this->customerRepository->addCustomer($customer);

//            count discounted total price
            if ($coupon)
            {
                $total_price = $this->countTotalAfterDiscountUc->countTotalAfterDiscount($total_price, $discountAmount);
                $this->couponRepository->deactivate($cpn[0]);
            }
            
            $order = new Order();
            $order->setCustomer($customer);
            $order->setDescription($cus['description']);
            $order->setTotal($total_price);
            $order->setOrderNumber('ADIS' . time());
            if($coupon) $order->setCoupon($cpn[0]);
            $order = $this->orderRepository->addOrder($order);

            foreach($foods as $food) {
                // find Food entity from DB
                $f = $this->foodRepository->findFood($food['id']);
                for($i=0; $i < $food['amount']; $i++) {
                    $fo = new FoodOrder();
                    $fo->setFood($f);
                    $fo->setOrder($order);
                    $this->foodOrderRepository->addFoodOrder($fo);
                }
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return new CreateOrderResponse($e->getMessage(), 'Internal Server Error' ,$e->getCode());
        }

        return new CreateOrderResponse("Order created.", "Created", 201);
    }
}