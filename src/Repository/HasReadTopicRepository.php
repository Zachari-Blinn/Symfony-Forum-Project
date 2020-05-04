<?php

namespace App\Repository;

use App\Entity\HasReadTopic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HasReadTopic|null find($id, $lockMode = null, $lockVersion = null)
 * @method HasReadTopic|null findOneBy(array $criteria, array $orderBy = null)
 * @method HasReadTopic[]    findAll()
 * @method HasReadTopic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HasReadTopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HasReadTopic::class);
    }

    // /**
    //  * @return HasReadTopic[] Returns an array of HasReadTopic objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?HasReadTopic
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
