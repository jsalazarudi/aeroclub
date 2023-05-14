<?php

namespace App\Controller;

use App\Entity\MovimientoStock;
use App\Entity\ProductoVenta;
use App\Entity\Usuario;
use App\Entity\Venta;
use App\Form\VentaType;
use App\Repository\ListaPrecioRepository;
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
    public function index(Request $request, VentaRepository $ventaRepository, PaginatorInterface $paginator): Response
    {
        $ventasQuery = $ventaRepository->createQueryBuilder('v');

        if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO')) {

            $ventasQuery->where('v.realizada = :usuario')
                ->setParameter('usuario', $this->getUser());
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
    public function new(Request                   $request, VentaRepository $ventaRepository,
                        MovimientoStockRepository $movimientoStockRepository, ListaPrecioRepository $listaPrecioRepository): Response
    {
        $ventum = new Venta();
        $form = $this->createForm(VentaType::class, $ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $ventum->setRealizada($this->getUser());

            if ($ventum->getProductoVentas()->isEmpty()) {
                $this->addFlash(
                    'error',
                    'No ha seleccionado ningún producto'
                );
                return $this->render('venta/new.html.twig', [
                    'ventum' => $ventum,
                    'form' => $form,
                ]);
            }

            foreach ($ventum->getProductoVentas() as $productoVenta) {

                /** Movimiento Stock */
                $stockEntrada = $movimientoStockRepository->getEntradaProducto($productoVenta->getProducto()) ?? 0;
                $stockSalida = $movimientoStockRepository->getSalidaProducto($productoVenta->getProducto()) ?? 0;

                if ($productoVenta->getCantidad() > ($stockEntrada - $stockSalida)) {
                    $this->addFlash(
                        'error',
                        sprintf("No hay %s cantidades del producto %s para sacar del stock, hay disponibles %s",
                            $productoVenta->getCantidad(), $productoVenta->getProducto()->getDescripcion(), $stockEntrada - $stockSalida)
                    );
                    return $this->render('venta/new.html.twig', [
                        'ventum' => $ventum,
                        'form' => $form,
                    ]);
                }

                $movimientoStock = $productoVenta->getMovimientoStock();
                $movimientoStockActualizado = $this->crearMovimientoStock($productoVenta, $movimientoStock);
                $productoVenta->setMovimientoStock($movimientoStockActualizado);

                /** Lista Precio Ventas Tesorero */
                if ($this->isGranted('ROLE_TESORERO')) {
                    $ultimoFechaHistorialListaPrecio = $listaPrecioRepository->getUltimoHistorialListaPrecio();

                    if (is_null($ultimoFechaHistorialListaPrecio)) {
                        $this->addFlash(
                            'error',
                            'No existe ningun historial de lista de precio o se obtuvieron dos historiales. Contactarse con el tesorero para resolver este inconveniente'
                        );
                        return $this->render('venta/new.html.twig', [
                            'ventum' => $ventum,
                            'form' => $form,
                        ]);
                    }


                    $listaPrecioProducto = $listaPrecioRepository->getProducto($ultimoFechaHistorialListaPrecio, $productoVenta->getProducto(), $this->getUser()->getRoles()[0]);

                    if (is_null($listaPrecioProducto)) {

                        $this->addFlash(
                            'error',
                            sprintf('No hay lista de precios configuradas o hay conflictos con al producto %s', $productoVenta->getProducto()->getDescripcion())
                        );
                        return $this->render('venta/new.html.twig', [
                            'ventum' => $ventum,
                            'form' => $form,
                        ]);
                    }

                    $productoVenta->setListaPrecio($listaPrecioProducto);
                }
            }

            $ventaRepository->save($ventum, true);
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
    public function edit(Request                   $request, Venta $ventum, VentaRepository $ventaRepository,
                         MovimientoStockRepository $movimientoStockRepository, ListaPrecioRepository $listaPrecioRepository): Response
    {
        $form = $this->createForm(VentaType::class, $ventum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($this->getUser()->getId() != $ventum->getRealizada()->getId()) {
                $this->addFlash(
                    'error',
                    'No se permite editar compras/ventas que no sean las de su usuario'
                );
                return $this->redirectToRoute('app_venta_index', [], Response::HTTP_SEE_OTHER);

            }

            if ($ventum->getProductoVentas()->isEmpty()) {
                $this->addFlash(
                    'error',
                    'No ha seleccionado ningún producto'
                );
                return $this->render('venta/edit.html.twig', [
                    'ventum' => $ventum,
                    'form' => $form,
                ]);
            }

            foreach ($ventum->getProductoVentas() as $productoVenta) {

                /** Movimiento Stock */
                $stockEntrada = $movimientoStockRepository->getEntradaProducto($productoVenta->getProducto()) ?? 0;
                $stockSalida = $movimientoStockRepository->getSalidaProducto($productoVenta->getProducto()) ?? 0;

                if ($productoVenta->getCantidad() > ($stockEntrada - $stockSalida)) {
                    $this->addFlash(
                        'error',
                        sprintf("No hay %s cantidades del producto %s para sacar del stock, hay disponibles %s",
                            $productoVenta->getCantidad(), $productoVenta->getProducto()->getDescripcion(), $stockEntrada - $stockSalida)
                    );
                    return $this->render('venta/edit.html.twig', [
                        'ventum' => $ventum,
                        'form' => $form,
                    ]);
                }

                $movimientoStock = $productoVenta->getMovimientoStock();
                $movimientoStockActualizado = $this->crearMovimientoStock($productoVenta, $movimientoStock);
                $productoVenta->setMovimientoStock($movimientoStockActualizado);

                /** Lista Precio Ventas Tesorero */
                if ($this->isGranted('ROLE_TESORERO')) {
                    $ultimoFechaHistorialListaPrecio = $listaPrecioRepository->getUltimoHistorialListaPrecio();
                    $listaPrecioProducto = $listaPrecioRepository->getProducto($ultimoFechaHistorialListaPrecio, $productoVenta->getProducto(), $this->getUser()->getRoles()[0]);

                    if (is_null($listaPrecioProducto)) {

                        $this->addFlash(
                            'error',
                            sprintf('No hay lista de precios o existen conflictos relacionados al producto %s', $productoVenta->getProducto()->getDescripcion())
                        );
                        return $this->render('venta/new.html.twig', [
                            'ventum' => $ventum,
                            'form' => $form,
                        ]);
                    }

                    $productoVenta->setListaPrecio($listaPrecioProducto);
                }

            }

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
        if ($this->isCsrfTokenValid('delete' . $ventum->getId(), $request->request->get('_token'))) {
            $ventaRepository->remove($ventum, true);
        }

        return $this->redirectToRoute('app_venta_index', [], Response::HTTP_SEE_OTHER);
    }

    private function crearMovimientoStock(ProductoVenta $productoVenta, ?MovimientoStock $movimientoStock): MovimientoStock
    {
        if (is_null($movimientoStock)) {
            $movimientoStock = new MovimientoStock();
        }

        $movimientoStock->setCantidad($productoVenta->getCantidad());
        $movimientoStock->setTipo('Salida');

        /** @var Usuario $usuario */
        $usuario = $this->getUser();

        $movimientoStock->setObservaciones(sprintf('Movimiento de Salida desde una Compra del aeroclub por parte de %s %s', $usuario->getNombre(), $usuario->getApellido()));
        $movimientoStock->setRealizado($usuario);
        $movimientoStock->setProducto($productoVenta->getProducto());

        return $movimientoStock;
    }
}
