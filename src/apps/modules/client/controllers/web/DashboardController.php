<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;


class DashboardController extends Controller
{


    // services
    protected $orderService;
    protected $foodService;
    protected $serializer;
    protected $couponService;

    public function initialize()
    {
        $this->orderService = $this->di->get('orderService');
        $this->foodService = $this->di->get('foodService');
        $this->couponService = $this->di->get('couponService');
        $this->serializer = $this->di->get('serializer');
    }
    
    public function indexAction()
    {        

        $foods = $this->foodService->getAvailableFoods();
        $this->view->foods = $foods;

        return $this->view->pick('dashboard/index');
    }

    public function ordersAction()
    {
        $orders = $this->orderService->allOrder();
        $this->view->orders = $orders;
        return $this->view->pick('dashboard/orders');
    }

    public function generateReceiptAction($order_id)
    {
        $receipt = $this->orderService->generateReceipt($order_id);
        $receipt->download();
    }

    public function renderReceiptTemplateAction()
    {
        return $this->view->pick('dashboard/generated-receipt');
    }

    public function foodsAction()
    {
        $foods = $this->foodService->getAvailableFoods();
        $this->view->foods = $foods;
        $this->view->pick('dashboard/foods');
    }

    public function couponsAction()
    {
        $coupons = $this->couponService->allCoupons();
        $this->view->coupons = $coupons;
        $this->view->pick('dashboard/coupons');
    }



}

