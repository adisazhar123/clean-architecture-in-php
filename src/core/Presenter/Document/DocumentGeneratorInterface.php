<?php
namespace RestoOrder\Presenter\Document;

interface DocumentGeneratorInterface 
{
    public function createDocument($template);
}