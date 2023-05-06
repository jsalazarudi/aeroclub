<?php

namespace App\Controller;

use App\Entity\MovimientoStock;
use App\Entity\Tesorero;
use App\Entity\Usuario;
use App\Form\MovimientoStockType;
use App\Repository\MovimientoStockRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/movimiento/stock')]
class MovimientoStockController extends AbstractController
{
    #[Route('/', name: 'app_movimiento_stock_index', methods: ['GET'])]
    public function index(Request $request,MovimientoStockRepository $movimientoStockRepository, PaginatorInterface $paginator): Response
    {

        $stockQuery = $movimientoStockRepository->createQueryBuilder('m');

        $query = $stockQuery->getQuery();

        $stocks = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('movimiento_stock/index.html.twig', [
            'stocks' => $stocks,
        ]);
    }

    #[Route('/new/{tipo}', name: 'app_movimiento_stock_new', methods: ['GET', 'POST'])]
    public function new(string $tipo, Request $request, MovimientoStockRepository $movimientoStockRepository): Response
    {
        $movimientoStock = new MovimientoStock();
        $form = $this->createForm(MovimientoStockType::class, $movimientoStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $movimientoStock->setRealizado($this->getUser());

            if ($tipo == 'ingreso') {
                $movimientoStock->setTipo('Entrada');
            } elseif ($tipo == 'salida') {

                $entrada = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockEntrada')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Entrada'")
                    ->setParameter('producto',$movimientoStock->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $salida = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockSalida')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Salida'")
                    ->setParameter('producto',$movimientoStock->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $stockEntrada = $entrada ?? 0;
                $stockSalida = $salida ?? 0;

                if ($movimientoStock->getCantidad() > ($stockEntrada - $stockSalida)) {
                    $this->addFlash(
                        'error',
                        sprintf("No hay %s cantidades del producto %s para sacar del stock, hay disponibles %s",
                            $movimientoStock->getCantidad(),$movimientoStock->getProducto()->getDescripcion(),$stockEntrada - $stockSalida)
                    );
                    return $this->redirectToRoute('app_movimiento_stock_new',['tipo' => $tipo]);
                }


                $movimientoStock->setTipo('Salida');
            } else {
                $this->addFlash(
                    'error',
                    'Tipo de movimiento stock no valido'
                );
                $this->redirectToRoute('app_movimiento_stock_new',['tipo' => $tipo]);
            }


            $movimientoStockRepository->save($movimientoStock, true);

            return $this->redirectToRoute('app_movimiento_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movimiento_stock/new.html.twig', [
            'movimiento_stock' => $movimientoStock,
            'form' => $form,
            'tipo' => $tipo
        ]);
    }

    #[Route('/{id}', name: 'app_movimiento_stock_show', methods: ['GET'])]
    public function show(MovimientoStock $movimientoStock): Response
    {
        return $this->render('movimiento_stock/show.html.twig', [
            'movimiento_stock' => $movimientoStock,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_movimiento_stock_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, MovimientoStock $movimientoStock, MovimientoStockRepository $movimientoStockRepository): Response
    {
        $form = $this->createForm(MovimientoStockType::class, $movimientoStock);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $movimientoStockRepository->save($movimientoStock, true);

            return $this->redirectToRoute('app_movimiento_stock_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('movimiento_stock/edit.html.twig', [
            'movimiento_stock' => $movimientoStock,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_movimiento_stock_delete', methods: ['POST'])]
    public function delete(Request $request, MovimientoStock $movimientoStock, MovimientoStockRepository $movimientoStockRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $movimientoStock->getId(), $request->request->get('_token'))) {
            $movimientoStockRepository->remove($movimientoStock, true);
        }

        return $this->redirectToRoute('app_movimiento_stock_index', [], Response::HTTP_SEE_OTHER);
    }
}
