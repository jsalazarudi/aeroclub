<?php

namespace App\Controller;

use App\Entity\HistorialListaPrecio;
use App\Entity\ListaPrecio;
use App\Form\HistorialListaPrecioType;
use App\Repository\HistorialListaPrecioRepository;
use App\Repository\ListaPrecioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/historial/lista/precio')]
class HistorialListaPrecioController extends AbstractController
{
    #[Route('/', name: 'app_historial_lista_precio_index', methods: ['GET'])]
    public function index(Request $request, HistorialListaPrecioRepository $historialListaPrecioRepository, PaginatorInterface $paginator): Response
    {
        $historialListaPreciosQuery = $historialListaPrecioRepository->createQueryBuilder('hl');

        $query = $historialListaPreciosQuery->getQuery();

        $historialListaPrecios = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('historial_lista_precio/index.html.twig', [
            'historial_lista_precios' => $historialListaPrecios,
        ]);
    }

    #[Route('/new', name: 'app_historial_lista_precio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HistorialListaPrecioRepository $historialListaPrecioRepository, ListaPrecioRepository $listaPrecioRepository): Response
    {
        $historialListaPrecio = new HistorialListaPrecio();
        $form = $this->createForm(HistorialListaPrecioType::class, $historialListaPrecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var string $ultimaFechaHistorialListaPrecios */
            $ultimaFechaHistorialListaPrecios = $historialListaPrecioRepository->createQueryBuilder('hlp')
                ->select('MAX(hlp.fecha) AS fecha')
                ->getQuery()
                ->getSingleScalarResult();

            /** @var HistorialListaPrecio $ultimaHistorialListaPrecios */
            $ultimaHistorialListaPrecios = $historialListaPrecioRepository->createQueryBuilder('hlp')
                ->where('hlp.fecha = :fecha')
                ->setParameter('fecha', $ultimaFechaHistorialListaPrecios)
                ->getQuery()
                ->getSingleResult();

            foreach ($ultimaHistorialListaPrecios->getListaPrecios() as $ultimaListaPrecio) {
                $nuevaListaPrecio = new ListaPrecio();

                $aumento = ceil($ultimaListaPrecio->getPrecio() * $historialListaPrecio->getPorcentajeCambio() / 100);
                $nuevoPrecio = $ultimaListaPrecio->getPrecio() + $aumento;

                $nuevaListaPrecio->setPrecio($nuevoPrecio);
                $nuevaListaPrecio->setHistorialListaPrecio($historialListaPrecio);

                if ($ultimaListaPrecio->getServicio()) {
                    $nuevaListaPrecio->setServicio($ultimaListaPrecio->getServicio());
                }

                if ($ultimaListaPrecio->getProducto()) {
                    $nuevaListaPrecio->setProducto($ultimaListaPrecio->getProducto());
                }

                if ($ultimaListaPrecio->getAvion()) {
                    $nuevaListaPrecio->setAvion($ultimaListaPrecio->getAvion());
                }

                $nuevaListaPrecio->setSocio($ultimaListaPrecio->isSocio());
                $nuevaListaPrecio->setAlumno($ultimaListaPrecio->isAlumno());

                $listaPrecioRepository->save($nuevaListaPrecio);
            }

            $historialListaPrecioRepository->save($historialListaPrecio, true);

            return $this->redirectToRoute('app_historial_lista_precio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historial_lista_precio/new.html.twig', [
            'historial_lista_precio' => $historialListaPrecio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historial_lista_precio_show', methods: ['GET'])]
    public function show(HistorialListaPrecio $historialListaPrecio): Response
    {
        return $this->render('historial_lista_precio/show.html.twig', [
            'historial_lista_precio' => $historialListaPrecio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_historial_lista_precio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, HistorialListaPrecio $historialListaPrecio, HistorialListaPrecioRepository $historialListaPrecioRepository): Response
    {
        $form = $this->createForm(HistorialListaPrecioType::class, $historialListaPrecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $historialListaPrecioRepository->save($historialListaPrecio, true);

            return $this->redirectToRoute('app_historial_lista_precio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('historial_lista_precio/edit.html.twig', [
            'historial_lista_precio' => $historialListaPrecio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_historial_lista_precio_delete', methods: ['POST'])]
    public function delete(Request $request, HistorialListaPrecio $historialListaPrecio, HistorialListaPrecioRepository $historialListaPrecioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $historialListaPrecio->getId(), $request->request->get('_token'))) {
            $historialListaPrecioRepository->remove($historialListaPrecio, true);
        }

        return $this->redirectToRoute('app_historial_lista_precio_index', [], Response::HTTP_SEE_OTHER);
    }
}
