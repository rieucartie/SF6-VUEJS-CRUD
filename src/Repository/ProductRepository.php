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
    public function create($data)
    {
        $product= new Product();

        $product->setTitle($data->title);
        $product->setPrice($data->price);
        $product->setDescription($data->description);

        $this->getEntityManager()->persist($product);
        $this->getEntityManager()->flush();
    }

    public function update($productnewData, $oldId)
    {
        $qb = $this->createQueryBuilder('p');
        $qb->update(Product::class, 'p');

        if (isset($productnewData->title)) {
            $qb->set('p.title', ':title')
                ->setParameter('title', $productnewData->title);
        }
        if (isset($productnewData->price)) {
            $qb->set('p.price', ':price')
                ->setParameter('price', $productnewData->price);
        }
        if (isset($productnewData->description)) {
            $qb->set('p.description', ':description')
                ->setParameter('description', $productnewData->description);
        }

        $qb->where('p.id = :oldId')
            ->setParameter('oldId', $oldId);

        $query = $qb->getQuery();
        $query->execute();
    }

    public function searchByKeyword($keyword)
    {
        return $this->createQueryBuilder('p')
            ->where('p.title LIKE :keyword')
            ->setParameter('keyword', '%' . $keyword . '%')
            ->getQuery()
            ->getResult();
    }

}
