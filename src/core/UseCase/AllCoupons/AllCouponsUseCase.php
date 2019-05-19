<?php


namespace RestoOrder\UseCase\AllCoupons;


use RestoOrder\Domain\Repository\CouponRepositoryInterface;

class AllCouponsUseCase
{
    protected $couponRepo;

    public function __construct(CouponRepositoryInterface $cr)
    {
        $this->couponRepo = $cr;
    }

    public function allCoupons(): AllCouponsResponse
    {
        $coupons = $this->couponRepo->allCoupons();
        $response = new AllCouponsResponse();
        $response->setCoupons($coupons);
        return $response;
    }
}