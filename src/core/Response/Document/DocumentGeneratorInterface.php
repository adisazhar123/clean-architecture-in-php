<?php
namespace RestoOrder\Response\Document;

interface DocumentGeneratorInterface 
{
    public function createDocument($template);
}