<?php

namespace App\Repository;

use App\Entity\ListingCity;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingCity|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingCity|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingCity[]    findAll()
 * @method ListingCity[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingCityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingCity::class);
    }

    // /**
    //  * @return ListingCity[] Returns an array of ListingCity objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('l.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ListingCity
    {
        return $this->createQueryBuilder('l')
            ->andWhere('l.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
