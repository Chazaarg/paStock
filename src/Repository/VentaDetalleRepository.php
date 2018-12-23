<?php

namespace App\Repository;

use App\Entity\VentaDetalle;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VentaDetalle|null find($id, $lockMode = null, $lockVersion = null)
 * @method VentaDetalle|null findOneBy(array $criteria, array $orderBy = null)
 * @method VentaDetalle[]    findAll()
 * @method VentaDetalle[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VentaDetalleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VentaDetalle::class);
    }

    /**
     * @return VentaDetalle[] Returns an array of VentaDetalle objects
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
    public function findOneBySomeField($value): ?VentaDetalle
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
