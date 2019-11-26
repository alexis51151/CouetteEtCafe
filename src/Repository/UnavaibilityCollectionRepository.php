<?php

namespace App\Repository;

use App\Entity\UnavaibilityCollection;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method UnavaibilityCollection|null find($id, $lockMode = null, $lockVersion = null)
 * @method UnavaibilityCollection|null findOneBy(array $criteria, array $orderBy = null)
 * @method UnavaibilityCollection[]    findAll()
 * @method UnavaibilityCollection[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UnavaibilityCollectionRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, UnavaibilityCollection::class);
    }

    // /**
    //  * @return UnavaibilityCollection[] Returns an array of UnavaibilityCollection objects
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
    public function findOneBySomeField($value): ?UnavaibilityCollection
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
