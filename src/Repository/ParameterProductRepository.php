<?php

namespace App\Repository;

use App\Entity\ParameterProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ParameterProduct>
 *
 * @method ParameterProduct|null find($id, $lockMode = null, $lockVersion = null)
 * @method ParameterProduct|null findOneBy(array $criteria, array $orderBy = null)
 * @method ParameterProduct[]    findAll()
 * @method ParameterProduct[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ParameterProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ParameterProduct::class);
    }

    public function save(ParameterProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ParameterProduct $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }
}
