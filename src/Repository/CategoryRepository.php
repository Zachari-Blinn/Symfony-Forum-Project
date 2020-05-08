<?php

namespace App\Repository;

use App\Entity\Topic;
use Doctrine\ORM\Query;
use App\Entity\Category;
use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    // /**
    //  * @return Category[] Returns an array of Category objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Category
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    /**
     * Undocumented function
     *
     * @param Topic $topic
     * @return integer
     */
    public function findVuesByTopic(?Topic $topic): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT COUNT(h)
             FROM App\Entity\Category c
             LEFT JOIN c.topic t
             LEFT JOIN t.hasReadTopics h
             WHERE h.topic = :topic'
            )->setParameter('topic', $topic);

        return $query->getSingleScalarResult();
    }

    /**
     * Count all message on category
     * 
     * @param Category $category
     * @return integer
     */
    public function countAllMessages(?Category $category): int
    {
        $entityManager = $this->getEntityManager();

        $query = $entityManager->createQuery(
            'SELECT COUNT(comments)
             FROM App\Entity\Category category
             LEFT JOIN category.topic topic
             LEFT JOIN topic.comments comments
             WHERE category = :cat'
            )->setParameter('cat', $category);

        return $query->getSingleScalarResult();
    }
}
