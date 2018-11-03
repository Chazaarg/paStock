<?php

namespace App\Repository;

use App\Entity\Marca;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Marca|null find($id, $lockMode = null, $lockVersion = null)
 * @method Marca|null findOneBy(array $criteria, array $orderBy = null)
 * @method Marca[]    findAll()
 * @method Marca[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MarcaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Marca::class);
    }

//    /**
//     * @return Marca[] Returns an array of Marca objects
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
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('m.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Marca
    {
        return $this->createQueryBuilder('m')
            ->andWhere('m.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
