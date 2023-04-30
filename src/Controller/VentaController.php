<?php

namespace App\Controller;

use App\Entity\MovimientoStock;
use App\Entity\Venta;
use App\Form\VentaType;
use App\Repository\MovimientoStockRepository;
use App\Repository\VentaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/venta')]
class VentaController extends AbstractController
{
    #[Route('/', name: 'app_venta_index', methods: ['GET'])]
    public function index(Request $request,VentaRepository $ventaRepository, PaginatorInterface $paginator): Response
    {
        $ventasQuery = $ventaRepository->createQueryBuilder('v');

        if ($this->isGranted('ROLE_SOCIO')) {
            $socio = $this->getUser()->getSocio();
            $ventasQuery->where('v.socio = :socio')
                ->setParameter('socio',$socio);
        }

        if ($this->isGranted('ROLE_PILOTO')) {
            $piloto = $this->getUser()->getPiloto();
            $ventasQuery->where('v.piloto = :socio')
                ->setParameter('piloto',$piloto);
        }

        $query = $ventasQuery->getQuery();

        $ventas = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('venta/index.html.twig', [
            'ventas' => $ventas,
        ]);
    }

    #[Route('/new', name: 'app_venta_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VentaRepository $ventaRepository, MovimientoStockRepository $movimientoStockRepository): Response
    {
        $ventum = new Venta();
        $form = $this->createForm(VentaType::class, $ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($this->isGranted('ROLE_SOCIO')) {
                $ventum->setSocio($this->getUser()->getSocio());
            } elseif ($this->isGranted('ROLE_PILOTO')) {
                $ventum->setPiloto($this->getUser()->getPiloto());
            }
            elseif ($this->isGranted('ROLE_TESORERO')) {
                $ventum->setTesorero($this->getUser()->getTesorero());
            }

            // MOVER EL STOCK
            $movimientosStock = [];
            foreach ($ventum->getProductoVentas() as $productoVenta) {

                $entrada = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockEntrada')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Entrada'")
                    ->setParameter('producto', $productoVenta->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $salida = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockSalida')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Salida'")
                    ->setParameter('producto', $productoVenta->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $stockEntrada = $entrada ?? 0;
                $stockSalida = $salida ?? 0;

                if ($productoVenta->getCantidad() > ($stockEntrada - $stockSalida)) {
                    $this->addFlash(
                        'error',
                        sprintf("No hay %s cantidades del producto %s para sacar del stock, hay disponibles %s",
                            $productoVenta->getCantidad(),$productoVenta->getProducto()->getDescripcion(),$stockEntrada - $stockSalida)
                    );
                    return $this->redirectToRoute('app_venta_new');
                }

                $movimientoStock = new MovimientoStock();
                $movimientoStock->setCantidad($productoVenta->getCantidad());
                $movimientoStock->setTipo('Salida');
                $movimientoStock->setObservaciones('Movimiento de Salida desde Venta del aeroclub');
                $movimientoStock->setProducto($productoVenta->getProducto());

                $movimientosStocks[] = $movimientoStock;
            }

            $ventaRepository->save($ventum, true);
            foreach ($movimientosStocks as $movimientosStock){
                $movimientoStockRepository->save($movimientosStock,true);
            }

            return $this->redirectToRoute('app_venta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('venta/new.html.twig', [
            'ventum' => $ventum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_venta_show', methods: ['GET'])]
    public function show(Venta $ventum): Response
    {
        return $this->render('venta/show.html.twig', [
            'ventum' => $ventum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_venta_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Venta $ventum, VentaRepository $ventaRepository): Response
    {
        $form = $this->createForm(VentaType::class, $ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $ventaRepository->save($ventum, true);

            return $this->redirectToRoute('app_venta_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('venta/edit.html.twig', [
            'ventum' => $ventum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_venta_delete', methods: ['POST'])]
    public function delete(Request $request, Venta $ventum, VentaRepository $ventaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ventum->getId(), $request->request->get('_token'))) {
            $ventaRepository->remove($ventum, true);
        }

        return $this->redirectToRoute('app_venta_index', [], Response::HTTP_SEE_OTHER);
    }
}
