<?php

namespace App\Repository;

use App\Entity\MovimientoStock;
use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<MovimientoStock>
 *
 * @method MovimientoStock|null find($id, $lockMode = null, $lockVersion = null)
 * @method MovimientoStock|null findOneBy(array $criteria, array $orderBy = null)
 * @method MovimientoStock[]    findAll()
 * @method MovimientoStock[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MovimientoStockRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, MovimientoStock::class);
    }

    public function save(MovimientoStock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(MovimientoStock $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getEntradaProducto(Producto $producto)
    {
        $query = $this->createQueryBuilder('m')
            ->select('SUM(m.cantidad) AS stockEntrada')
            ->where('m.producto = :producto')
            ->andWhere("m.tipo = 'Entrada'")
            ->setParameter('producto', $producto)
            ->getQuery();

        try {
            return $query->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return 0;
        }
    }

    public function getSalidaProducto(Producto $producto)
    {
        $query = $this->createQueryBuilder('m')
            ->select('SUM(m.cantidad) AS stockSalida')
            ->where('m.producto = :producto')
            ->andWhere("m.tipo = 'Salida'")
            ->setParameter('producto', $producto)
            ->getQuery();

        try {
            return $query->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return 0;
        }
    }
}
