<?php

namespace AntoineLemaire\BlacklistBundle\Manager;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class BaseManager.
 */
abstract class BaseManager
{
    /**
     * @var EntityManagerInterface
     */
    protected $em;

    /**
     * @var string
     */
    protected $class;

    /**
     * @var \Doctrine\ORM\EntityRepository
     */
    protected $repository;

    /**
     * @var \Doctrine\ORM\Mapping\ClassMetadata
     */
    protected $metadata;

    /**
     * @param \Doctrine\ORM\EntityManagerInterface $em
     * @param string                               $class
     */
    public function __construct(EntityManagerInterface $em, $class)
    {
        $this->em         = $em;
        $this->repository = $em->getRepository($class);

        $this->metadata = $em->getClassMetadata($class);
        $this->class    = $this->metadata->name;
    }

    public function getClass()
    {
        return $this->class;
    }

    /**
     * @return \Doctrine\ORM\Mapping\ClassMetadata
     */
    public function getMetadata()
    {
        return $this->metadata;
    }

    /**
     * @return mixed
     */
    public function create()
    {
        $class = $this->getClass();

        return new $class();
    }

    /**
     * @param mixed $entity
     * @param bool  $andFlush
     */
    public function update($entity, $andFlush = true)
    {
        $this->em->persist($entity);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * @param object $entity
     * @param bool   $andFlush
     */
    public function delete($entity, $andFlush = true)
    {
        $this->em->remove($entity);
        if ($andFlush) {
            $this->em->flush();
        }
    }

    /**
     * @param array $criteria
     * @param bool  $exception
     *
     * @throws NotFoundHttpException
     *
     * @return object|null
     */
    public function findOneBy(array $criteria, $exception = false)
    {
        $entity = $this->repository->findOneBy($criteria);
        if ($exception && !$entity) {
            throw new NotFoundHttpException('Unable to find entity.');
        }

        return $entity;
    }

    /**
     * @param array    $criteria
     * @param array    $order
     * @param null|int $limit
     * @param null|int $offset
     *
     * @return array
     */
    public function findBy(array $criteria, array $order = [], $limit = null, $offset = null)
    {
        return $this->repository->findBy($criteria, $order, $limit, $offset);
    }

    /**
     * @param int  $id
     * @param bool $exception
     *
     * @throws NotFoundHttpException
     *
     * @return null|object
     */
    public function find($id, $exception = false)
    {
        $entity = $this->repository->find($id);
        if ($exception && !$entity) {
            throw new NotFoundHttpException('Unable to find entity.');
        }

        return $entity;
    }

    /**
     * @return array
     */
    public function findAll()
    {
        return $this->repository->findAll();
    }

    /**
     * @param object $entity
     */
    public function refresh($entity)
    {
        $this->em->refresh($entity);
    }

    /**
     * @return \Doctrine\ORM\EntityRepository
     */
    public function getRepository()
    {
        return $this->repository;
    }
}
