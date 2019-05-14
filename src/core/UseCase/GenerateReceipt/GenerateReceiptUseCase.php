<?php


namespace RestoOrder\UseCase\GenerateReceipt;


use RestoOrder\Domain\Repository\OrderRepositoryInterface;
use RestoOrder\Response\Document\DocumentGeneratorInterface;
use RestoOrder\UseCase\FindOrder\FindOrderResponse;

class GenerateReceiptUseCase
{
    protected $orderRepository;
    protected $pdfGenerator;

    public function __construct(OrderRepositoryInterface $orderRepository, DocumentGeneratorInterface $docGenerator)
    {
        $this->orderRepository = $orderRepository;
        $this->pdfGenerator = $docGenerator;
    }

    public function generateReceipt($id) : GenerateReceiptResponse
    {
        $order = $this->orderRepository->getById($id);
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
                <h4>ADIS</h4>
                
                <table id=\"customers\">
                  <tr>
                    <th>Company</th>
                    <th>Contact</th>
                    <th>Country</th>
                  </tr>
                  ". $html['foods'] ."
                </table>
                
                <h3>Total: </h3>
                <h4>845769</h4>
                
                </body>
            </html>
            ";

        $receipt = $this->pdfGenerator->createDocument($template);
        return new GenerateReceiptResponse($receipt);

    }

    public function receiptDataToHtml(FindOrderResponse $receiptData)
    {
        $foods = '';

        foreach ($receiptData->getFoods() as $food)
        {
            $foods .= "<tr>
                        <td>".$food['name']."</td>
                        <td>".$food['description']."</td>
                        <td>".$food['price']."</td>
                      </tr>";
        }

        return ['foods' => $foods];
    }
}