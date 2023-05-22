<?php

namespace App\Repository;

use App\Entity\ListaPrecio;
use App\Entity\Producto;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<ListaPrecio>
 *
 * @method ListaPrecio|null find($id, $lockMode = null, $lockVersion = null)
 * @method ListaPrecio|null findOneBy(array $criteria, array $orderBy = null)
 * @method ListaPrecio[]    findAll()
 * @method ListaPrecio[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ListaPrecioRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ListaPrecio::class);
    }

    public function save(ListaPrecio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(ListaPrecio $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getUltimoHistorialListaPrecio()
    {
        $queryHistorialListsPrecio = $this->createQueryBuilder('lp')
            ->join('lp.historial_lista_precio', 'hlp')
            ->select('MAX(hlp.fecha) AS fecha')
            ->getQuery();

        try {
            return $queryHistorialListsPrecio->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return null;
        }
    }

    public function getProducto($ultimaHistorialListaPrecio,Producto $producto, ?string $rol)
    {
        $listaPrecioQuery = $this->createQueryBuilder('lp')
            ->join('lp.historial_lista_precio', 'historial')
            ->where('lp.producto = :producto')
            ->andWhere('historial.fecha = :fecha')
            ->setParameter('producto', $producto)
            ->setParameter('fecha', $ultimaHistorialListaPrecio);

        if ($rol === 'ROLE_SOCIO') {
            $listaPrecioQuery->andWhere('lp.socio = true');
        }
        else {
            $listaPrecioQuery->andWhere('lp.socio = false');
        }
        try {
            return $listaPrecioQuery->getQuery()->getSingleResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            return null;
        }
    }
}
