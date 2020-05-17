<?php

namespace App\Repository;

use App\Entity\Party;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Party|null find($id, $lockMode = null, $lockVersion = null)
 * @method Party|null findOneBy(array $criteria, array $orderBy = null)
 * @method Party[]    findAll()
 * @method Party[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PartyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Party::class);
    }

    /**
     * Find all next party no expirated 
     *
     * @return Party|null
     */ 
    public function findAllNextParty(): ?array
    {
        return $this->createQueryBuilder('party')
            ->select('party.title', 'party.id')
            ->andWhere('party.expireAt > :date_now')
            ->setParameter('date_now', new \DateTime())
            ->orderBy('party.partyAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

}
