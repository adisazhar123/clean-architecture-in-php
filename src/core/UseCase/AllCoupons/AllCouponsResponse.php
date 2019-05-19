<?php


namespace RestoOrder\UseCase\AllCoupons;


class AllCouponsResponse
{
    protected $coupons = [];

    /**
     * @return array
     */
    public function getCoupons(): array
    {
        return $this->coupons;
    }

    /**
     * @param array $coupons
     */
    public function setCoupons(array $coupons)
    {
        foreach ($coupons as $coupon)
        {
            $this->coupons [] = ['name' => $coupon->getName(), 'description' => $coupon->getDescription(), 'discount_amount' => $coupon->getDiscountAmount(), 'min_spending' => $coupon->getMinSpending(), 'code' => $coupon->getCode(), 'active' => $coupon->getActive(), 'min_date' => $coupon->getMinDate()->format('d-m-Y'), 'max_date' => $coupon->getMaxDate()->format('d-m-Y')];
        }
    }


}