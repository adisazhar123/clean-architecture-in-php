<?php


namespace App\Client\Controllers\Web;
use Phalcon\Mvc\Controller;


class CouponsController extends Controller
{
    protected $couponService;

    public function initialize()
    {
        $this->couponService = $this->di->get('couponService');
    }

    public function addCouponAction()
    {
        $coupon = $this->couponService->addCoupon($_POST);
        switch ($coupon->getHttpCode()) {
            case 201:
                $this->flashSession->success($coupon->getMessage());
                break;
            case 400:
                $this->flashSession->error($coupon->getMessage());
                break;
        }
        $this->response->redirect('/coupons');
    }
}