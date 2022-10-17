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

    public function productsArray($request)
    {
        $result = $this->createQueryBuilder('p')
            ->select('p');

        if (!empty($request->get('category_id'))) {
            $result->andWhere("p.category IN(:cat_ids)")
                ->setParameter('cat_ids', array_values($request->get('category_id')));
        }

        if (!empty($request->get('manufacturer_id'))) {
            $result->andWhere("p.manufacturer IN(:man_ids)")
                ->setParameter('man_ids', array_values($request->get('manufacturer_id')));
        }

        if ($request->get('from_price')) {
            $result->andWhere("p.price >= :from_price")
                ->setParameter('from_price', $request->get('from_price'));
        }

        if ($request->get('to_price')) {
            $result->andWhere("p.price <= :to_price")
                ->setParameter('to_price', $request->get('to_price'));
        }

        if (!empty($request->get('params'))) {
            $result->join('p.parameterProducts', 'pp');
            foreach ($request->get('params') as $par_id => $par_val) {
                $result
                    ->andWhere("pp.value IN(:par_val) AND pp.parameter = :par_id")
                    ->setParameter('par_val', array_values($par_val))
//                    ->andWhere("pp.parameter = :par_id")
                    ->setParameter('par_id', $par_id);
            }
        }

        return $result->getQuery()
            ->getArrayResult();
//            ->getSQL();
    }
}
