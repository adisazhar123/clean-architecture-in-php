<?php

namespace App\Client\Controllers\Api;

use Phalcon\Mvc\Controller;

class OrdersController extends Controller
{    protected $orderService;
    protected $foodService;
    protected $serializer;

    public function initialize()
    {
        $this->orderService = $this->di->get('orderService');
        $this->foodService = $this->di->get('foodService');
        $this->serializer = $this->di->get('serializer');
    }

    public function findOrderAction($order_id)
    {
        $order = $this->orderService->findOrder($order_id);
        $orderJson = $this->serializer->toJson($order);

        $this->response->setContent($orderJson);
        $this->response->send();
    }

    public function createOrderAction()
    {
        $createdOrderResponse = $this->orderService->createOrder($_POST);
        $createdOrderResponseJson = $this->serializer->toJson($createdOrderResponse);
        $this->response->setStatusCode($createdOrderResponse->getCode(), $createdOrderResponse->getHttpMessage());
        $this->response->setContent($createdOrderResponseJson);
        $this->response->send();
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