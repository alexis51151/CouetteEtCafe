<?php

namespace App\Repository;

use App\Entity\Unavaibility;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Unavaibility|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unavaibility|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unavaibility[]    findAll()
 * @method Unavaibility[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnavaibilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unavaibility::class);
    }

    // /**
    //  * @return Unavaibility[] Returns an array of Unavaibility objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('u.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Unavaibility
    {
        return $this->createQueryBuilder('u')
            ->andWhere('u.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
