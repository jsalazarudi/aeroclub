<?php

namespace App\Repository;

use App\Entity\InstructorVuelo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<InstructorVuelo>
 *
 * @method InstructorVuelo|null find($id, $lockMode = null, $lockVersion = null)
 * @method InstructorVuelo|null findOneBy(array $criteria, array $orderBy = null)
 * @method InstructorVuelo[]    findAll()
 * @method InstructorVuelo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class InstructorVueloRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, InstructorVuelo::class);
    }

    public function save(InstructorVuelo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(InstructorVuelo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return InstructorVuelo[] Returns an array of InstructorVuelo objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('i.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?InstructorVuelo
//    {
//        return $this->createQueryBuilder('i')
//            ->andWhere('i.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
