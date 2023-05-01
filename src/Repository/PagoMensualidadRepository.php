<?php

namespace App\Repository;

use App\Entity\PagoMensualidad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PagoMensualidad>
 *
 * @method PagoMensualidad|null find($id, $lockMode = null, $lockVersion = null)
 * @method PagoMensualidad|null findOneBy(array $criteria, array $orderBy = null)
 * @method PagoMensualidad[]    findAll()
 * @method PagoMensualidad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PagoMensualidadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PagoMensualidad::class);
    }

    public function save(PagoMensualidad $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(PagoMensualidad $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return PagoMensualidad[] Returns an array of PagoMensualidad objects
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

//    public function findOneBySomeField($value): ?PagoMensualidad
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
