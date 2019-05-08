<?php


namespace RestoOrder\Domain\Factory;

use RestoOrder\Domain\Entity\Invoice;
use RestoOrder\Domain\Entity\Order;

class InvoiceFactory
{
    public function createFromOrder(Order $order) {
        $invoice = new Invoice();
        $invoice->setOrder($order);
        $invoice->setInvoiceDate(new \DateTime());
        $invoice->setTotal($order->getTotal());
        return $invoice;
    }
}