<?php


namespace RestoOrder\Domain\Service;

use RestoOrder\UseCase\AddCoupon\AddCouponRequest;
use RestoOrder\UseCase\AddCoupon\AddCouponResponse;
use RestoOrder\UseCase\AddCoupon\AddCouponUseCase;
use RestoOrder\UseCase\AllCoupons\AllCouponsUseCase;
use RestoOrder\UseCase\FindCoupon\FindCouponUseCase;

class CouponService
{
    protected $addCouponUc;
    protected $allCouponsUc;
    protected $findCouponUc;

    public function __construct(AddCouponUseCase $ac, AllCouponsUseCase $acu, FindCouponUseCase $fc)
    {
        $this->addCouponUc = $ac;
        $this->allCouponsUc = $acu;
        $this->findCouponUc = $fc;
    }

    public function allCoupons()
    {
        $coupons = $this->allCouponsUc->allCoupons();
        return $coupons;
    }

    public function addCoupon($postCoupon): AddCouponResponse
    {
        $minDate = date_create($postCoupon['min_date']);
        $maxDate = date_create($postCoupon['max_date']);

        $request = new AddCouponRequest;
        $request->setDiscountAmount($postCoupon['discount_amount']);
        $request->setName($postCoupon['name']);
        $request->setActive(1);
        $request->setMaxDate($maxDate);
        $request->setMinDate($minDate);
        $request->setMinSpending($postCoupon['min_spending']);
        $request->setCode($postCoupon['code']);
        $request->setDescription($postCoupon['description']);
        return $this->addCouponUc->addCoupon($request);
    }
}