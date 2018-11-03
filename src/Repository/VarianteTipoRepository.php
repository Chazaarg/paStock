<?php

namespace App\Repository;

use App\Entity\VarianteTipo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method VarianteTipo|null find($id, $lockMode = null, $lockVersion = null)
 * @method VarianteTipo|null findOneBy(array $criteria, array $orderBy = null)
 * @method VarianteTipo[]    findAll()
 * @method VarianteTipo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VarianteTipoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, VarianteTipo::class);
    }

//    /**
//     * @return VarianteTipo[] Returns an array of VarianteTipo objects
//     */
    public function findAllAsc()
        {
            return $this->createQueryBuilder('m')
                ->orderBy('m.nombre', 'ASC')
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
    public function findOneBySomeField($value): ?VarianteTipo
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
