<?php

namespace App\Repository;

use App\Entity\Venta;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Venta|null find($id, $lockMode = null, $lockVersion = null)
 * @method Venta|null findOneBy(array $criteria, array $orderBy = null)
 * @method Venta[]    findAll()
 * @method Venta[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VentaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Venta::class);
    }

    /**
     * @return Venta[] Returns an array of Venta objects
     */
    public function findByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'DESC') //Del más nuevo al más viejo
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByDate($user, $date)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.createdAt >= :date')
            ->setParameter('user', $user)
            ->setParameter('date', $date)
            ->orderBy('p.id', 'DESC') //Del más nuevo al más viejo
            ->getQuery()
            ->getResult()
        ;
    }
    public function findByCustom($user, $desde, $hasta)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.createdAt >= :desde')
            ->andWhere('p.createdAt <= :hasta')
            ->setParameter('user', $user)
            ->setParameter('desde', $desde)
            ->setParameter('hasta', $hasta)
            ->orderBy('p.id', 'DESC') //Del más nuevo al más viejo
            ->getQuery()
            ->getResult()
        ;
    }
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('v.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Venta
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
