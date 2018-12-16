<?php

namespace App\Repository;

use App\Entity\SubCategoria;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SubCategoria|null find($id, $lockMode = null, $lockVersion = null)
 * @method SubCategoria|null findOneBy(array $criteria, array $orderBy = null)
 * @method SubCategoria[]    findAll()
 * @method SubCategoria[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SubCategoriaRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SubCategoria::class);
    }

    /**
     * @return SubCategoria[] Returns an array of SubCategoria objects
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
    public function findAllAsc()
            {
                return $this->createQueryBuilder('m')
                    ->orderBy('m.nombre', 'ASC')
                    ->getQuery()
                    ->getResult()
                ;
            }
    */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SubCategoria
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
