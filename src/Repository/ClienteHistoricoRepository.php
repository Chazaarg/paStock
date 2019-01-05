<?php

namespace App\Repository;

use App\Entity\ClienteHistorico;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ClienteHistorico|null find($id, $lockMode = null, $lockVersion = null)
 * @method ClienteHistorico|null findOneBy(array $criteria, array $orderBy = null)
 * @method ClienteHistorico[]    findAll()
 * @method ClienteHistorico[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ClienteHistoricoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ClienteHistorico::class);
    }

//    /**
//     * @return ClienteHistorico[] Returns an array of ClienteHistorico objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('c.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ClienteHistorico
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
