<?php

namespace App\Repository;

use App\Entity\HasReadComment;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method HasReadComment|null find($id, $lockMode = null, $lockVersion = null)
 * @method HasReadComment|null findOneBy(array $criteria, array $orderBy = null)
 * @method HasReadComment[]    findAll()
 * @method HasReadComment[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HasReadCommentRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HasReadComment::class);
    }

    // /**
    //  * @return HasReadComment[] Returns an array of HasReadComment objects
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
    public function findOneBySomeField($value): ?HasReadComment
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
