<?php

namespace App\Client\Controllers\Web;

use Phalcon\Mvc\Controller;
use RestoOrder\Domain\Entity\Food;
use RestoOrder\Domain\Entity\Order;
use RestoOrder\Domain\Entity\Customer;

class OrdersController extends Controller
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
        return $this->view->pick('orders');
    }


}


?>