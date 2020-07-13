<?php

namespace App\Repository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

abstract class AbstractRepository extends ServiceEntityRepository
{

    public function findAllIndexed($key)
    {
        $qb = $this->createQueryBuilder('entity');
        $query = $qb->indexBy('entity', 'entity.' . $key)->getQuery();
        return $query->getResult();
    }
}