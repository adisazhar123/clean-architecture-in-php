<?php


namespace RestoOrder\UseCase\GenerateReceipt;


use RestoOrder\Domain\Repository\OrderRepositoryInterface;
use RestoOrder\Helpers\CurrencyTrait;
use RestoOrder\Presenter\Document\DocumentGeneratorInterface;
use RestoOrder\UseCase\FindOrder\FindOrderResponse;

class GenerateReceiptUseCase implements GenerateReceiptUseCaseInterface
{
    use CurrencyTrait;

    protected $orderRepository;
    protected $pdfGenerator;

    public function __construct(OrderRepositoryInterface $orderRepository, DocumentGeneratorInterface $docGenerator)
    {
        $this->orderRepository = $orderRepository;
        $this->pdfGenerator = $docGenerator;
    }

    public function generateReceipt($id) : GenerateReceiptResponse
    {
        $order = $this->orderRepository->findOrder($id);
        $receiptData = new FindOrderResponse($order);

       $html = $this->receiptDataToHtml($receiptData);

        $template = "
            <!DOCTYPE html>
            <html>
            <head>
                <style>
                #customers {
                  font-family: \"Trebuchet MS\", Arial, Helvetica, sans-serif;
                  border-collapse: collapse;
                  width: 100%;
                }
                
                #customers td, #customers th {
                  border: 1px solid #ddd;
                  padding: 8px;
                }
                
                #customers tr:nth-child(even){background-color: #f2f2f2;}
                
                #customers tr:hover {background-color: #ddd;}
                
                #customers th {
                  padding-top: 12px;
                  padding-bottom: 12px;
                  text-align: left;
                  background-color: #4CAF50;
                  color: white;
                }
                </style>
            </head>
                <body>
                
                <h3>Billed To:</h3>
                <h4> ". $html['customer'] ."</h4>
                
                <table id=\"customers\">
                  <tr>
                    <th>Food</th>
                    <th>Description</th>
                    <th>Price</th>
                  </tr>
                  ". $html['foods'] ."
                </table>
                
                <h3>Total: </h3>
                <h4>Rp ". $this->formatToRupiah($html['total'])."</h4>
                <h3>Discounted Total: </h3>
                <h4>Rp ". $this->formatToRupiah($html['discounted'])."</h4>
                ". $html['coupon'] ."
                </body>
            </html>
            ";
        $receipt = $this->pdfGenerator->createDocument($template);
        return new GenerateReceiptResponse($receipt);

    }

    public function receiptDataToHtml(FindOrderResponse $receiptData)
    {
        $foods = '';
        $coupon = '';
        $total = 0;
        $customer = $receiptData->getOrder()['customer'];

        foreach ($receiptData->getFoods() as $food)
        {
            $foods .= "<tr>
                        <td>".$food['name']."</td>
                        <td>".$food['description']."</td>
                        <td>Rp ". $this->formatToRupiah($food['price']) ."</td>
                      </tr>";
            $total += $food['price'];
        }
        $coupon = $receiptData->getCoupon()[0];
        $couponHtml = '';
        if( $coupon)// $coupon .= "<p>Coupon name: ". $receiptData->getCoupon()[0]->getName() ."</p><p>Code: ". $receiptData->getCoupon()[0]->getCode() ."</p>";
            $couponHtml = "<p>Coupon: ". $receiptData->getCoupon()[0]->getName() ."</p><p>Code: ". $receiptData->getCoupon()[0]->getCode() ."</p>";
//        error_log($receiptData->getCoupon()[0]->getName() . "\n", 3, '/home/adisazhar/Desktop/phalcon.log');

        return ['foods' => $foods, 'total' => $total, 'customer' => $customer, 'discounted' => $receiptData->getOrder()['total_price'], 'coupon' => $couponHtml];
    }
}