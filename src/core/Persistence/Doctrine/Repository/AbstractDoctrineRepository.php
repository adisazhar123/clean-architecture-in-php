<?php


namespace RestoOrder\Persistence\Doctrine\Repository;

use Doctrine\ORM\EntityManager;
use http\Exception\RuntimeException;
use RestoOrder\Domain\Entity\AbstractEntity;
use RestoOrder\Domain\Repository\RepositoryInterface;

abstract class AbstractDoctrineRepository implements RepositoryInterface
{
    protected $entityManager;
    protected $entityClass;

    public function __construct(EntityManager $em)
    {
        if(empty($this->entityClass))
        {
            throw new \RuntimeException(
                get_class($this) . '::$entityClass is not defined'
            );
        }

        $this->entityManager = $em;
        $this->entityManager->clear();
    }

    public function getById($id)
    {
        return $this->entityManager->find($this->entityClass, $id);
    }

    public function getAll()
    {
        return $this->entityManager->getRepository($this->entityClass)
            ->findAll();
    }

    public function getBy($conditions = [], $order = [], $limit = null, $offset = null)
    {
        $repository = $this->entityManager->getRepository($this->entityClass);
        $results = $repository->findBy($conditions, $order, $limit, $offset);
    }

    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
        return $this;
    }

    public function begin()
    {
        $this->entityManager->beginTransaction();
        return $this;
    }

    public function commit()
    {
        $this->entityManager->flush();
        $this->entityManager->commit();
        return $this;
    }
}