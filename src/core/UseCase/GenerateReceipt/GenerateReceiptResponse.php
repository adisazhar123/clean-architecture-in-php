<?php


namespace RestoOrder\UseCase\GenerateReceipt;


class GenerateReceiptResponse
{
    protected $receipt;

    public function __construct($receipt)
    {
        $this->receipt = $receipt;
    }

    public function download()
    {
        $this->receipt->stream();
    }
}