<?php


namespace RestoOrder\Persistence\Doctrine\Repository;


use RestoOrder\Domain\Repository\CouponRepositoryInterface;

class CouponRepository extends AbstractDoctrineRepository implements CouponRepositoryInterface
{
    protected $entityClass = 'RestoOrder\Domain\Entity\Coupon';

    public function addCoupon($coupon)
    {
        $coupon = $this->persist($coupon);
        return $coupon;
    }

    public function findCoupon($code)
    {
        $coupon = $this->getBy(['code' => $code, 'active' => 1], [], 1);;
        return $coupon;
    }

    public function allCoupons()
    {
        $coupons = $this->getAll();
        return $coupons;
    }

    public function checkAvailability($code)
    {
//        coupon cannot be added if there is one with similar code with active status == 1
        $notAvailable = $this->getBy(['code' => $code, 'active' => 1], [], 1);
        return $notAvailable;
    }

    public function deactivate($couponEntity)
    {
        $couponEntity->setActive(0);
        $coupon = $this->persist($couponEntity);
        return $coupon;
    }
}