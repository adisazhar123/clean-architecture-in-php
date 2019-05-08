<?php


namespace RestoOrder\Domain\Repository;


interface RepositoryInterface
{
    public function getById($id);
    public function getAll();
    public function getBy($conditions = [], $order = [], $limit = null, $offset = null);
    public function persist($entity);
    public function begin();
    public function commit();
}