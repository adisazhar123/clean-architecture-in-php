<?php
namespace RestoOrder\Presenter\Serializer;

interface SerializerInterface {
    public function toJson($entity);
}