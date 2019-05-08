<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;
use RestoOrder\Domain\Entity\Food;
use RestoOrder\Domain\Entity\Order;
use RestoOrder\Domain\Entity\Customer;

class DashboardController extends Controller
{

    protected $customerRepository;
    protected $foodRepository;
    private $orderRepository;

    public function initialize()
    {
        $this->customerRepository = $this->di->get('customerRepository');
        $this->foodRepository = $this->di->get('foodRepository');
        $this->orderRepository = $this->di->get('orderRepository');
    }
    
    public function indexAction()
    {        
        $customers = $this->customerRepository->getAll();
        $foods = $this->foodRepository->getAll();

        $this->view->viewModel = [
            'customers' => $customers, 
            'foods' => $foods
        ];
        
        return $this->view->pick('dashboard/index');
    }

    public function createOrderAction()
    {
        $cus = $this->request->getPost('customer');

        $customer = new Customer();
        $customer->setName($cus['name']);
        $customer->setPhone($cus['phone']);
        
        $foods = $this->request->getPost('foods');        

        $total = 0;

        $order = new Order();

        foreach($foods as $food) {
            // find Food entity from DB
            $f = $this->foodRepository->getById($food['id']);
            
            // calculate total price
            $food_total = $food['amount'] * $food['price'];
            $total += $food_total;
            
            // need to attach the Food entity
            $order->addFood($f);
        }
        
        $this->customerRepository->persist($customer);        
        
        $order->setCustomer($customer);
        $order->setDescription($cus['description']);
        $order->setTotal($total);
        $order->setOrderNumber('ADIS' . time());
        $f->addOrder($order);
        $this->orderRepository->persist($order);
        
        return 'ok';
    }

    public function ordersAction()
    {        
        $orders = $this->orderRepository->getAll();
        $this->view->orders = $orders;
        return $this->view->pick('dashboard/orders');
    }

    public function generateReceiptAction()
    {
        
    }

    public function findOrderAction($order_id)
    {
        $order = $this->orderRepository->getById($order_id);
        $orderViewModel = [
            'foods' => $order->getFoods()->toArray()
        ];

        $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
        $jsonContent = $serializer->serialize($orderViewModel, 'json');

        $this->response->setContent($jsonContent);
        $this->response->send();
    }

}


?>