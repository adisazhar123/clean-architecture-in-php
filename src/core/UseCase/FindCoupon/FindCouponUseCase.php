<?php


namespace RestoOrder\UseCase\FindCoupon;


use RestoOrder\Domain\Repository\CouponRepositoryInterface;

class FindCouponUseCase
{
    protected $couponRepo;

    public function __construct(CouponRepositoryInterface $cr)
    {
        $this->couponRepo = $cr;
    }

    public function findCoupon($id)
    {
        $coupon = $this->findCoupon($id);
        return $coupon;
    }
}