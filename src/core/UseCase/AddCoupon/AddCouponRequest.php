<?php


namespace RestoOrder\UseCase\AddCoupon;


class AddCouponRequest
{
    protected $name;
    protected $description;
    protected $minDate;
    protected $maxDate;
    protected $active;
    protected $discountAmount;
    protected $minSpending;
    protected $code;

    /**
     * @return mixed
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param mixed $code
     */
    public function setCode($code)
    {
        $this->code = $code;
    }
    protected $order;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getMinDate()
    {
        return $this->minDate;
    }

    /**
     * @param mixed $minDate
     */
    public function setMinDate($minDate)
    {
        $this->minDate = $minDate;
    }

    /**
     * @return mixed
     */
    public function getMaxDate()
    {
        return $this->maxDate;
    }

    /**
     * @param mixed $maxDate
     */
    public function setMaxDate($maxDate)
    {
        $this->maxDate = $maxDate;
    }

    /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getDiscountAmount()
    {
        return $this->discountAmount;
    }

    /**
     * @param mixed $discountAmount
     */
    public function setDiscountAmount($discountAmount)
    {
        $this->discountAmount = $discountAmount;
    }

    /**
     * @return mixed
     */
    public function getMinSpending()
    {
        return $this->minSpending;
    }

    /**
     * @param mixed $minSpending
     */
    public function setMinSpending($minSpending)
    {
        $this->minSpending = $minSpending;
    }

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order)
    {
        $this->order = $order;
    }
}