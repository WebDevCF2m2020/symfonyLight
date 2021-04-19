<?php

namespace App\Repository;

use App\Entity\TheUser;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method TheUser|null find($id, $lockMode = null, $lockVersion = null)
 * @method TheUser|null findOneBy(array $criteria, array $orderBy = null)
 * @method TheUser[]    findAll()
 * @method TheUser[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TheUserRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TheUser::class);
    }

    // /**
    //  * @return TheUser[] Returns an array of TheUser objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('t.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?TheUser
    {
        return $this->createQueryBuilder('t')
            ->andWhere('t.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
