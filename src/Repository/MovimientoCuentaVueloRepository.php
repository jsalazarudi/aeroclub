<?php

namespace App\Repository;

use App\Entity\MovimientoCuentaVuelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovimientoCuentaVuelo>
 *
 * @method MovimientoCuentaVuelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovimientoCuentaVuelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovimientoCuentaVuelo[]    findAll()
 * @method MovimientoCuentaVuelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimientoCuentaVueloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoCuentaVuelo::class);
    }

    public function save(MovimientoCuentaVuelo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MovimientoCuentaVuelo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return MovimientoCuentaVuelo[] Returns an array of MovimientoCuentaVuelo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('m.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?MovimientoCuentaVuelo
//    {
//        return $this->createQueryBuilder('m')
//            ->andWhere('m.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
