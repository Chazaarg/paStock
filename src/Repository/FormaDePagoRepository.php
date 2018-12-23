<?php

namespace App\Repository;

use App\Entity\FormaDePago;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method FormaDePago|null find($id, $lockMode = null, $lockVersion = null)
 * @method FormaDePago|null findOneBy(array $criteria, array $orderBy = null)
 * @method FormaDePago[]    findAll()
 * @method FormaDePago[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FormaDePagoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, FormaDePago::class);
    }

    /**
      * @return FormaDePago[] Returns an array of FormaDePago objects
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
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('f.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?FormaDePago
    {
        return $this->createQueryBuilder('f')
            ->andWhere('f.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
