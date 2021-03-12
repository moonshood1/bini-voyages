<?php

namespace App\Repository;

use App\Entity\ListingImage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ListingImage|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListingImage|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListingImage[]    findAll()
 * @method ListingImage[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListingImageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListingImage::class);
    }

    // /**
    //  * @return ListingImage[] Returns an array of ListingImage objects
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
    public function findOneBySomeField($value): ?ListingImage
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
