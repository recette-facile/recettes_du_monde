<?php

namespace App\Repository;

use App\Entity\RecetteFavori;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method RecetteFavori|null find($id, $lockMode = null, $lockVersion = null)
 * @method RecetteFavori|null findOneBy(array $criteria, array $orderBy = null)
 * @method RecetteFavori[]    findAll()
 * @method RecetteFavori[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class RecetteFavoriRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, RecetteFavori::class);
    }

    // /**
    //  * @return RecetteFavori[] Returns an array of RecetteFavori objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('r.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?RecetteFavori
    {
        return $this->createQueryBuilder('r')
            ->andWhere('r.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
