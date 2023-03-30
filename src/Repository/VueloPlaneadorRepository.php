<?php

namespace App\Repository;

use App\Entity\VueloPlaneador;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<VueloPlaneador>
 *
 * @method VueloPlaneador|null find($id, $lockMode = null, $lockVersion = null)
 * @method VueloPlaneador|null findOneBy(array $criteria, array $orderBy = null)
 * @method VueloPlaneador[]    findAll()
 * @method VueloPlaneador[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VueloPlaneadorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, VueloPlaneador::class);
    }

    public function save(VueloPlaneador $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(VueloPlaneador $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return VueloPlaneador[] Returns an array of VueloPlaneador objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('v.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?VueloPlaneador
//    {
//        return $this->createQueryBuilder('v')
//            ->andWhere('v.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
