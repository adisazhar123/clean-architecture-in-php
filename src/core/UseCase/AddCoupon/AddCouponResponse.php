<?php


namespace RestoOrder\UseCase\AddCoupon;


class AddCouponResponse
{
    protected $message;
    protected $httpCode;
    protected $httpMessage;
    protected $coupon = [];

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return mixed
     */
    public function getHttpCode()
    {
        return $this->httpCode;
    }

    /**
     * @param mixed $httpCode
     */
    public function setHttpCode($httpCode)
    {
        $this->httpCode = $httpCode;
    }

    /**
     * @return mixed
     */
    public function getHttpMessage()
    {
        return $this->httpMessage;
    }

    /**
     * @param mixed $httpMessage
     */
    public function setHttpMessage($httpMessage)
    {
        $this->httpMessage = $httpMessage;
    }

    /**
     * @return array
     */
    public function getCoupon(): array
    {
        return $this->coupon;
    }

    /**
     * @param array $coupon
     */
    public function setCoupon(array $coupon)
    {
        $this->coupon = $coupon;
    }


}