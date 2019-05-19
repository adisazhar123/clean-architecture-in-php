<?php


namespace RestoOrder\Domain\Repository;


interface CouponRepositoryInterface
{
    public function addCoupon($coupon);
    public function findCoupon($id);
    public function allCoupons();
    public function checkAvailability($code);
    public function deactivate($couponEntity);
}