<?php


namespace RestoOrder\Domain\Service;


use RestoOrder\Domain\Factory\InvoiceFactory;
use RestoOrder\Domain\Repository\OrderRepositoryInterface;

class InvoicingService
{
    protected $orderRespository;
    protected $invoiceFactory;

    public function __construct(OrderRepositoryInterface $orderRepository, InvoiceFactory $invoiceFactory)
    {
        $this->orderRespository = $orderRepository;
        $this->invoiceFactory = $invoiceFactory;
    }

    public function generateInvoices()
    {
        $orders = $this->orderRespository->getUninvoicedOrders();

        $invoices = [];

        foreach ($orders as $order)
        {
            $invoices[] = $this->invoiceFactory->createFromOrder($order);
        }
        return $invoices;
    }
}