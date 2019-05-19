<?php

namespace App\Client;

use Dompdf\Dompdf;
use Dompdf\Options;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\DiInterface;
use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ModuleDefinitionInterface;
use RestoOrder\Domain\Repository\CustomerRepositoryInterface;
use RestoOrder\Domain\Service\CouponService;
use RestoOrder\UseCase\AddCoupon\AddCouponUseCase;
use RestoOrder\UseCase\AddFood\AddFoodUseCase;
use RestoOrder\UseCase\AllCoupons\AllCouponsUseCase;
use RestoOrder\UseCase\AllFoods\AllFoodsUseCase;
use RestoOrder\UseCase\AllOrders\AllOrdersUseCase;
use RestoOrder\UseCase\CanUseDiscount\CanUseDiscountUseCase;
use RestoOrder\UseCase\CountTotalAfterDiscount\CountTotalAfterDiscountUseCase;
use RestoOrder\UseCase\FindCoupon\FindCouponUseCase;
use RestoOrder\UseCase\FindFood\FindFoodUseCase;
use RestoOrder\UseCase\GenerateReceipt\GenerateReceiptUseCase;
use RestoOrder\UseCase\UpdateFood\UpdateFoodUseCase;

class Module implements ModuleDefinitionInterface
{   
    /**
     * Register a specific autoloader for the module
     */
    public function registerAutoloaders(DiInterface $di = null)
    {
        $loader = new Loader();

        $loader->registerNamespaces([
            'App\Client\Controllers\Web' => __DIR__ . '/controllers/web',
            'App\Client\Controllers\Api' => __DIR__ . '/controllers/api',
            'App\Client\Models' => __DIR__ . '/models',
            'App\Client\Services' => __DIR__ . '/services',
            'App\Client\Contracts' => __DIR__ . '/contracts',
            // 'RestoOrder' => __DIR__ .'/../../../core',
//            'RestoOrder\Domain\Repository' => __DIR__ .'/../../../core/Domain/Repository',
//            'RestoOrder\Persistence\Doctrine\Repository' => __DIR__ .'/../.    ./../core/Persistence/Doctrine/Repository',
        ]);

        $loader->register();
    }

    /**
     * Register specific services for the module
     */
    public function registerServices(DiInterface $di = null)
    {
        // Registering the view component
        $di['view'] = function () {
            $view = new View();
            $view->setViewsDir(__DIR__ . '/views/');

            $view->registerEngines(
                [
                    ".volt" => "voltService",
                ]
            );

            return $view;
        };


        $di->setShared('entityManager', function() {
            
            $paths = array(__DIR__ . "/../../../core/Persistence/Doctrine/Mapping/");
            $isDevMode = true;

            // the connection configuration
            $dbParams = array(
                'driver'   => 'pdo_mysql',
                'user'     => 'adis',
                'password' => '',
                'dbname'   => 'clean_architecture',
            );

            $config = Setup::createYAMLMetadataConfiguration($paths, $isDevMode);
            $entityManager = EntityManager::create($dbParams, $config);
            $entityManager->clear();
            return $entityManager;
        });

        $di->setShared('customerRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\CustomerRepository($entityManager);
        });

        $di->setShared('foodRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\FoodRepository($entityManager);
        });

        $di->setShared('orderRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\OrderRepository($entityManager);
        });

        $di->setShared('foodOrderRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\FoodOrderRepository($entityManager);
        });

        $di->set("createOrderUseCase", function() {
            $orderRepository = $this->get('orderRepository');
            $customerRepository = $this->get('customerRepository');
            $foodOrderRepository = $this->get('foodOrderRepository');
            $foodRepository = $this->get('foodRepository');
            $couponRepo = $this->get('couponRepository');
            $countTotalUc = new CountTotalAfterDiscountUseCase();
            $canUseDiscountUc = new CanUseDiscountUseCase();
            return new \RestoOrder\UseCase\CreateOrder\CreateOrderUseCase($customerRepository, $foodRepository, $orderRepository, $foodOrderRepository, $couponRepo, $countTotalUc, $canUseDiscountUc);
        });

        $di->set('findOrderUseCase', function() {
            $orderRepository = $this->get('orderRepository');
            return new \RestoOrder\UseCase\FindOrder\FindOrderUseCase($orderRepository);
        });

        $di->set('generateReceiptUseCase', function() {
            $orderRepository = $this->get('orderRepository');
            $pdfGenerator = $this->get('pdfGenerator');
            return new GenerateReceiptUseCase($orderRepository, $pdfGenerator);
        });

        $di->set('allFoodsUseCase', function() {
            $foodRepository = $this->get('foodRepository');
            return new AllFoodsUseCase($foodRepository);
        });

        $di->set('allOrdersUseCase', function() {
            $orderRepository = $this->get('orderRepository');
            return new AllOrdersUseCase($orderRepository);
        });

        $di->setShared('orderService', function() {
            $createOrderUc = $this->get('createOrderUseCase');
            $findOrderUc = $this->get('findOrderUseCase');
            $generateReceiptUc = $this->get('generateReceiptUseCase');
            $allOrdersUc = $this->get('allOrdersUseCase');

            return new \RestoOrder\Domain\Service\OrderService($createOrderUc, $findOrderUc, $generateReceiptUc, $allOrdersUc);
        });

        $di->setShared('couponRepository', function() {
            $entityManager = $this->get('entityManager');
            return new \RestoOrder\Persistence\Doctrine\Repository\CouponRepository($entityManager);
        });

        $di->set('allCouponsUseCase', function() {
           $couponRepo = $this->get('couponRepository');
           return new AllCouponsUseCase($couponRepo);
        });

        $di->set('addCouponUseCase', function() {
            $couponRepo = $this->get('couponRepository');
            return new AddCouponUseCase($couponRepo);
        });

        $di->set('findCouponUseCase', function() {
            $couponRepo = $this->get('couponRepository');
            return new FindCouponUseCase($couponRepo);
        });

        $di->set('couponService', function() {
           $findCouponUc = $this->get('findCouponUseCase');
           $addCouponUc = $this->get('addCouponUseCase');
           $allCouponsUc = $this->get('allCouponsUseCase');
           return new CouponService($addCouponUc, $allCouponsUc, $findCouponUc);
        });

        $di->set('addFoodUseCase', function() {
           $foodRepo = $this->get('foodRepository');
           return new AddFoodUseCase($foodRepo);
        });

        $di->set('findFoodUseCase', function() {
            $foodRepo = $this->get('foodRepository');
            return new FindFoodUseCase($foodRepo);
        });

        $di->set('updateFoodUseCase', function() {
            $foodRepo = $this->get('foodRepository');
            return new UpdateFoodUseCase($foodRepo);
        });

        $di->setShared('foodService', function() {
            $foodRepository = $this->get('foodRepository');
            $foodUc = $this->get('allFoodsUseCase');
            $addFoodUc = $this->get('addFoodUseCase');
            $findFoodUc = $this->get('findFoodUseCase');
            $updateFoodUc = $this->get('updateFoodUseCase');
            return new \RestoOrder\Domain\Service\FoodService($foodRepository, $foodUc, $addFoodUc, $findFoodUc, $updateFoodUc);
        });

        $di->setShared('jmsSerializer', function() {
            $serializer = \JMS\Serializer\SerializerBuilder::create()->build();
            return $serializer;
        });

        $di->setShared('serializer', function() {
            $jmsSerializer = $this->get('jmsSerializer');
            return new \RestoOrder\Presenter\Serializer\JmsSerializer($jmsSerializer);
        });

        $di->setShared('domPdf', function() {
            $options = new Options();
            $options->set('defaultFont', 'Courier');
            $dompdf = new Dompdf($options);

            return $dompdf;
        });

        $di->setShared('pdfGenerator', function() {
            $dompdf = $this->get('domPdf');

            return new \RestoOrder\Presenter\Document\DomPdfDocumentGenerator($dompdf);
        });
        

    }
}
