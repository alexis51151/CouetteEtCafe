<?php

namespace App\Repository;

use App\Entity\Unavailabilities;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Unavailabilities|null find($id, $lockMode = null, $lockVersion = null)
 * @method Unavailabilities|null findOneBy(array $criteria, array $orderBy = null)
 * @method Unavailabilities[]    findAll()
 * @method Unavailabilities[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnavailabilitiesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Unavailabilities::class);
    }

    // /**
    //  * @return Unavailabilities[] Returns an array of Unavailabilities objects
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
    public function findOneBySomeField($value): ?Unavailabilities
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
