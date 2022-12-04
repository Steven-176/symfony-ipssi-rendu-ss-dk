<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 *
 * @method Product|null find($id, $lockMode = null, $lockVersion = null)
 * @method Product|null findOneBy(array $criteria, array $orderBy = null)
 * @method Product[]    findAll()
 * @method Product[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function save(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Product $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    /**
    * @return Product[] Returns an array of Product objects
    */
    public function findByFilterType(int $price_min = null, int $price_max = null, string $seller = null, string $category = null, string $order = null): array
    {
        $qb = $this->createQueryBuilder('p');

        if ($price_min && $price_max) {
            $qb->andWhere('p.price BETWEEN :price_min AND :price_max')
                ->setParameter('price', $price);
        } elseif ($price_min) {
            $qb->andWhere('p.price >= :price_min')
                ->setParameter('price', $price);
        } elseif ($price_max) {
            $qb->andWhere('p.price <= :price_max')
                ->setParameter('price', $price);
        }

        if ($seller) {
            $qb->andWhere('p.seller = :seller')
                ->setParameter('seller', $seller);
        }
        
        if ($category) {
            $qb->andWhere('p.category = :category')
                ->setParameter('category', $category);
        }

        $qb->orderBy('p.created_at', ':order')
            ->setParameter('order', $order);

        return $qb->getQuery()->getResult();
    }

//    /**
//     * @return Product[] Returns an array of Product objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Product
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
