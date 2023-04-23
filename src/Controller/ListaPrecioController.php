<?php

namespace App\Controller;

use App\Entity\ListaPrecio;
use App\Form\ListaPrecioType;
use App\Repository\ListaPrecioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lista/precio')]
class ListaPrecioController extends AbstractController
{
    #[Route('/', name: 'app_lista_precio_index', methods: ['GET'])]
    public function index(Request $request, ListaPrecioRepository $listaPrecioRepository, PaginatorInterface $paginator): Response
    {
        $listaPreciosQuery = $listaPrecioRepository->createQueryBuilder('l');

        $query = $listaPreciosQuery->getQuery();

        $listaPrecios = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('lista_precio/index.html.twig', [
            'lista_precios' => $listaPrecios,
        ]);
    }

    #[Route('/new', name: 'app_lista_precio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ListaPrecioRepository $listaPrecioRepository): Response
    {
        $listaPrecio = new ListaPrecio();
        $form = $this->createForm(ListaPrecioType::class, $listaPrecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listaPrecioRepository->save($listaPrecio, true);

            return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lista_precio/new.html.twig', [
            'lista_precio' => $listaPrecio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lista_precio_show', methods: ['GET'])]
    public function show(ListaPrecio $listaPrecio): Response
    {
        return $this->render('lista_precio/show.html.twig', [
            'lista_precio' => $listaPrecio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lista_precio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListaPrecio $listaPrecio, ListaPrecioRepository $listaPrecioRepository): Response
    {
        $form = $this->createForm(ListaPrecioType::class, $listaPrecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listaPrecioRepository->save($listaPrecio, true);

            return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lista_precio/edit.html.twig', [
            'lista_precio' => $listaPrecio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lista_precio_delete', methods: ['POST'])]
    public function delete(Request $request, ListaPrecio $listaPrecio, ListaPrecioRepository $listaPrecioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $listaPrecio->getId(), $request->request->get('_token'))) {
            $listaPrecioRepository->remove($listaPrecio, true);
        }

        return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
    }
}
