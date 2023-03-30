<?php

namespace App\Repository;

use App\Entity\HistorialListaPrecio;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<HistorialListaPrecio>
 *
 * @method HistorialListaPrecio|null find($id, $lockMode = null, $lockVersion = null)
 * @method HistorialListaPrecio|null findOneBy(array $criteria, array $orderBy = null)
 * @method HistorialListaPrecio[]    findAll()
 * @method HistorialListaPrecio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HistorialListaPrecioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, HistorialListaPrecio::class);
    }

    public function save(HistorialListaPrecio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(HistorialListaPrecio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return HistorialListaPrecio[] Returns an array of HistorialListaPrecio objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('h.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?HistorialListaPrecio
//    {
//        return $this->createQueryBuilder('h')
//            ->andWhere('h.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
