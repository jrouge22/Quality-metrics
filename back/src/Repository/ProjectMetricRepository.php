<?php

namespace App\Repository;

use App\Entity\ProjectMetric;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProjectMetric|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProjectMetric|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProjectMetric[]    findAll()
 * @method ProjectMetric[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProjectMetricRepository extends AbstractRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProjectMetric::class);
    }

    // /**
    //  * @return ProjectMetric[] Returns an array of ProjectMetric objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProjectMetric
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
