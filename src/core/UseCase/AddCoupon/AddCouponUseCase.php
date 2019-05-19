<?php


namespace RestoOrder\UseCase\AddCoupon;


use RestoOrder\Domain\Entity\Coupon;
use RestoOrder\Domain\Repository\CouponRepositoryInterface;

class AddCouponUseCase
{
    protected $couponRepo;

    public function __construct(CouponRepositoryInterface $cr)
    {
        $this->couponRepo = $cr;
    }

    public function addCoupon(AddCouponRequest $request): AddCouponResponse
    {
        $notAvailable = $this->couponRepo->checkAvailability($request->getCode());
        if ($notAvailable) {
            $response = new AddCouponResponse();
            $response->setMessage('The provided coupon code already exists');
            $response->setHttpCode(400);
            $response->setHttpMessage('Bad Request');
            return $response;
        }

        $coupon = new Coupon();
        $coupon->setName($request->getName());
        $coupon->setDescription($request->getDescription());
        $coupon->setMinDate($request->getMinDate());
        $coupon->setMaxDate($request->getMaxDate());
        $coupon->setActive($request->getActive());
        $coupon->setDiscountAmount($request->getDiscountAmount());
        $coupon->setCode($request->getCode());
        $coupon->setMinSpending($request->getMinSpending());

        $coupon = $this->couponRepo->addCoupon($coupon);

        $response = new AddCouponResponse();
        $response->setMessage('Coupon added');
        $response->setHttpCode(201);
        $response->setHttpMessage('Created');
        $response->setCoupon(['name' => $coupon->getName(), 'discount_amount' => $coupon->getDiscountAmount(), 'min_spending' => $coupon->getMinSpending(), 'code' => $coupon->getCode()]);
        return $response;
    }
}