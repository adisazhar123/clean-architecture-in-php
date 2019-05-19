<?php


namespace RestoOrder\UseCase\CanUseDiscount;


class CanUseDiscountUseCase
{
    public function canUseDiscount($minSpending, $currentSpending, $minDate, $maxDate, $currentDate, $active)
    {
        $code = null;
        $messages = [];
        if (!$active)
        {
            $messages [] = "Coupon not active.";
            $code = 400;
        }
        //current spending has to be larger than minimum spending of coupon
        if ($minSpending > $currentSpending)
        {
            $code = 400;
            $messages [] = "Doesn't fulfill minimum spending.";
        }
//        check for date condition
        if ($currentDate > $maxDate || $currentDate < $minDate)
        {
            $code = 400;
            $messages [] = "Doesn't fulfill date condition.";
        }
        // if code is empty, then it must be a success
        if(!$code) {
            $code = 200;
            $messages [] = "Eligible.";
        }

        return ['messages' => $messages, 'code' => $code];
    }
}