<?php


namespace RestoOrder\UseCase\CountTotalAfterDiscount;


class CountTotalAfterDiscountUseCase
{
    public function countTotalAfterDiscount($totalSpending, $discountAmount)
    {
        $discount = doubleval($discountAmount/100) * doubleval($totalSpending);
        $salePrice = doubleval($totalSpending) - $discount;
        error_log("total spending: " . doubleval($totalSpending) . ", discount amount: " . doubleval($discountAmount/100) . "\n", 3, "/home/adisazhar/Desktop/phalcon.log");
        return $salePrice;
    }
}