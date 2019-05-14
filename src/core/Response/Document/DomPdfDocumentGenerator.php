<?php
namespace RestoOrder\Response\Document;

class DomPdfDocumentGenerator implements DocumentGeneratorInterface
{
    protected $generator;

    public function __construct($generator)
    {
        $this->generator = $generator;
    }

    public function createDocument($template)
    {
        $this->generator->loadHtml($template);
        // (Optional) Setup the paper size and orientation
        $this->generator->setPaper('A4', 'landscape');
        // Render the HTML as PDF
        $this->generator->render();
        return $this->generator;
        // Output the generated PDF to Browser
//        $this->generator->stream();
    }
}