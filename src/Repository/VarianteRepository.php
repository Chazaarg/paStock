<?php

namespace App\Repository;

use App\Entity\Variante;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Variante|null find($id, $lockMode = null, $lockVersion = null)
 * @method Variante|null findOneBy(array $criteria, array $orderBy = null)
 * @method Variante[]    findAll()
 * @method Variante[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VarianteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Variante::class);
    }

//    /**
//     * @return Variante[] Returns an array of Variante objects
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
    public function findOneBySomeField($value): ?Variante
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
