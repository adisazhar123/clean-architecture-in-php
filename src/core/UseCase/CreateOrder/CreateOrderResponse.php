<?php
namespace RestoOrder\UseCase\CreateOrder;

class CreateOrderResponse
{
    protected $message;
    protected $httpMessage;
    protected $code;

    public function __construct($message, $httpMessage, $code)
    {
        $this->httpMessage = $httpMessage;
        $this->message = $message;
        $this->code = $code;
    }

    public function getHttpMessage()
    {
        return $this->httpMessage;
    }

    public function getMessage()
    {
        return $this->message;
    }

    public function getCode()
    {
        return $this->code;
    }
}