<?php

namespace App\Repository;

use App\Entity\ProductoHistorico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ProductoHistorico|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProductoHistorico|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProductoHistorico[]    findAll()
 * @method ProductoHistorico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoHistoricoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ProductoHistorico::class);
    }

//    /**
//     * @return ProductoHistorico[] Returns an array of ProductoHistorico objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProductoHistorico
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
