<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;


class DashboardController extends Controller
{


    // services
    protected $orderService;
    protected $foodService;
    protected $serializer;

    public function initialize()
    {
        $this->orderService = $this->di->get('orderService');
        $this->foodService = $this->di->get('foodService');
        $this->serializer = $this->di->get('serializer');
    }
    
    public function indexAction()
    {        

        $foods = $this->foodService->getAvailableFoods();
        $this->view->foods = $foods;

        return $this->view->pick('dashboard/index');
    }

    public function createOrderAction()
    {
        $createdOrderResponse = $this->orderService->createOrder($_POST);
        $createdOrderResponseJson = $this->serializer->toJson($createdOrderResponse);
        $this->response->setStatusCode(201, $createdOrderResponse->getHttpMessage());
        $this->response->setContent($createdOrderResponseJson);
        $this->response->send();

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

    public function findOrderAction($order_id)
    {
        $order = $this->orderService->findOrder($order_id);
        $orderJson = $this->serializer->toJson($order);
     
        $this->response->setContent($orderJson);
        $this->response->send();
    }

    public function foodsAction()
    {
        $foods = $this->foodService->getAvailableFoods();
        $this->view->foods = $foods;
        $this->view->pick('dashboard/foods');
    }

    public function addFoodAction()
    {
        $food = $this->foodService->addFood($_POST);
        $foodJson = $this->serializer->toJson($food);

        $this->response->setContent($foodJson);
        $this->response->send();
    }

    public function findFoodAction($foodId)
    {
        $food = $this->foodService->findFood($foodId);
        $foodJson = $this->serializer->toJson($food);

        $this->response->setContent($foodJson);
        $this->response->send();
    }

    public function updateFoodAction($foodId)
    {
        $food = $this->foodService->updateFood($foodId, ['name' => $this->request->getPut('name'), 'description' => $this->request->getPut('description'),
            'price' => $this->request->getPut('price')]);
        $foodJson = $this->serializer->toJson($food);

        $this->response->setContent($foodJson);
        $this->response->send();
    }

}

