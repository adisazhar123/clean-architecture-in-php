<?php


namespace RestoOrder\Helpers;


trait CurrencyTrait
{
    public function formatToRupiah($price)
    {
        return number_format($price,2,',','.');
    }
}