<?php
namespace RestoOrder\Response\Serializer;

interface SerializerInterface {
    public function toJson($entity);
}