<?php

namespace App\Repository;

use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Security;

/**
 * @method Producto|null find($id, $lockMode = null, $lockVersion = null)
 * @method Producto|null findOneBy(array $criteria, array $orderBy = null)
 * @method Producto[]    findAll()
 * @method Producto[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductoRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Producto::class);
    }

    /**
     * @return Producto[] Returns an array of Producto objects
     */
    
    public function findByUser($user)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'DESC')//Del más nuevo al más viejo
            ->getQuery()
            ->getResult()
        ;
    }
    
    public function findDESC($user, $marca, $categoria, $subcategoria)
    {
        if (!$marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'DESC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->orderBy('p.id', 'DESC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.id', 'DESC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult()
;
        } elseif ($marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.id', 'DESC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult();
        } elseif (!$marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.id', 'DESC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult();
        } elseif (!$marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.id', 'DESC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult();
        }
    }
    public function findASC($user, $marca, $categoria, $subcategoria)
    {
        if (!$marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.id', 'ASC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->orderBy('p.id', 'ASC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.id', 'ASC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult()
;
        } elseif ($marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.id', 'ASC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult();
        } elseif (!$marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.id', 'ASC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult();
        } elseif (!$marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.id', 'ASC')//Del más viejo al más nuevo
            ->getQuery()
            ->getResult();
        }
    }
    public function findPriceDESC($user, $marca, $categoria, $subcategoria)
    {
        if (!$marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.precioPromedio', 'DESC')//Del más caro al más barato
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->orderBy('p.precioPromedio', 'DESC')//Del más caro al más barato
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.precioPromedio', 'DESC')//Del más caro al más barato
            ->getQuery()
            ->getResult()
;
        } elseif ($marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.precioPromedio', 'DESC')//Del más caro al más barato
            ->getQuery()
            ->getResult();
        } elseif (!$marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.precioPromedio', 'DESC')//Del más caro al más barato
            ->getQuery()
            ->getResult();
        } elseif (!$marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.precioPromedio', 'DESC')//Del más caro al más barato
            ->getQuery()
            ->getResult();
        }
    }
    
    public function findPriceASC($user, $marca, $categoria, $subcategoria)
    {
        if (!$marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.precioPromedio', 'ASC')//Del más barato al más caro
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->orderBy('p.precioPromedio', 'ASC')//Del más barato al más caro
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.precioPromedio', 'ASC')//Del más barato al más caro
            ->getQuery()
            ->getResult()
;
        } elseif ($marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.precioPromedio', 'ASC')//Del más barato al más caro
            ->getQuery()
            ->getResult();
        } elseif (!$marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.precioPromedio', 'ASC')//Del más barato al más caro
            ->getQuery()
            ->getResult();
        } elseif (!$marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.precioPromedio', 'ASC')//Del más barato al más caro
            ->getQuery()
            ->getResult();
        }
    }
            
    public function findCantDESC($user, $marca, $categoria, $subcategoria)
    {
        if (!$marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.cantidadPromedio', 'DESC')//Mayor cantidad a menor
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->orderBy('p.cantidadPromedio', 'DESC')//Mayor cantidad a menor
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.cantidadPromedio', 'DESC')//Mayor cantidad a menor
            ->getQuery()
            ->getResult()
;
        } elseif ($marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.cantidadPromedio', 'DESC')//Mayor cantidad a menor
            ->getQuery()
            ->getResult();
        } elseif (!$marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.cantidadPromedio', 'DESC')//Mayor cantidad a menor
            ->getQuery()
            ->getResult();
        } elseif (!$marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.cantidadPromedio', 'DESC')//Mayor cantidad a menor
            ->getQuery()
            ->getResult();
        }
    }
    public function findCantASC($user, $marca, $categoria, $subcategoria)
    {
        if (!$marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.cantidadPromedio', 'ASC')//Menor cantidad a Mayor
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && !$categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->orderBy('p.cantidadPromedio', 'ASC')//Menor cantidad a Mayor
            ->getQuery()
            ->getResult()
        ;
        } elseif ($marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.cantidadPromedio', 'ASC')//Menor cantidad a Mayor
            ->getQuery()
            ->getResult()
;
        } elseif ($marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.user = :user')
            ->andWhere('p.marca = :marca')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('marca', $marca)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.cantidadPromedio', 'ASC')//Menor cantidad a Mayor
            ->getQuery()
            ->getResult();
        } elseif (!$marca && $categoria && !$subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.categoria = :categoria')
            ->setParameter('user', $user)
            ->setParameter('categoria', $categoria)
            ->orderBy('p.cantidadPromedio', 'ASC')//Menor cantidad a Mayor
            ->getQuery()
            ->getResult();
        } elseif (!$marca && !$categoria && $subcategoria) {
            return $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->andWhere('p.subCategoria = :subcategoria')
            ->setParameter('user', $user)
            ->setParameter('subcategoria', $subcategoria)
            ->orderBy('p.cantidadPromedio', 'ASC')//Menor cantidad a Mayor
            ->getQuery()
            ->getResult();
        }
    }

    /*
    public function findOneBySomeField($value): ?Producto
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
