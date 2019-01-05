<?php

namespace App\Repository;

use App\Entity\VendedorHistorico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VendedorHistorico|null find($id, $lockMode = null, $lockVersion = null)
 * @method VendedorHistorico|null findOneBy(array $criteria, array $orderBy = null)
 * @method VendedorHistorico[]    findAll()
 * @method VendedorHistorico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VendedorHistoricoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VendedorHistorico::class);
    }

//    /**
//     * @return VendedorHistorico[] Returns an array of VendedorHistorico objects
//     */
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
    public function findOneBySomeField($value): ?VendedorHistorico
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
