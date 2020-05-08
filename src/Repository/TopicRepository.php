<?php

namespace App\Repository;

use App\Entity\Category;
use App\Entity\Topic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Topic|null find($id, $lockMode = null, $lockVersion = null)
 * @method Topic|null findOneBy(array $criteria, array $orderBy = null)
 * @method Topic[]    findAll()
 * @method Topic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Topic|null findViewsByTopic($topic)
 */
class TopicRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Topic::class);
    }

    /**
     * Count all views by topic
     *
     * @param Topic $topic
     * @return integer
     */
    public function countViewsByTopic(?Topic $topic): int
    {
        $entityManager = $this->getEntityManager();

        $queryBuilder = $entityManager->createQueryBuilder()
            ->select('count(h.id)') 
            ->from(Topic::class, 't')
            ->leftJoin('t.hasReadTopics', 'h')
            ->where('h.topic = :topic')
            ->setParameter('topic', $topic);
 
         $query = $queryBuilder->getQuery();

        return $query->getSingleScalarResult();
    }

    /**
     * Find all topics order by newest
     *
     * @param Category|null $category
     * @return Topic|null
     */ 
    public function findAllTopicByNewest(?Category $category): array
    {
        return $this->createQueryBuilder('topic')
            ->select('topic')
            ->andWhere('topic.isActive = true')
            ->andWhere('topic.category = :category')
            ->setParameter('category', $category)
            ->orderBy('topic.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

}
