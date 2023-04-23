<?php

namespace App\Controller;

use App\Entity\Avion;
use App\Form\AvionType;
use App\Repository\AvionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/avion')]
class AvionController extends AbstractController
{
    #[Route('/', name: 'app_avion_index', methods: ['GET'])]
    public function index(Request $request, AvionRepository $avionRepository, PaginatorInterface $paginator): Response
    {
        $avionesQuery = $avionRepository->createQueryBuilder('a');

        $query = $avionesQuery->getQuery();

        $aviones = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('avion/index.html.twig', [
            'aviones' => $aviones,
        ]);
    }

    #[Route('/new', name: 'app_avion_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AvionRepository $avionRepository): Response
    {
        $avion = new Avion();
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avionRepository->save($avion, true);

            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('avion/new.html.twig', [
            'avion' => $avion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avion_show', methods: ['GET'])]
    public function show(Avion $avion): Response
    {
        return $this->render('avion/show.html.twig', [
            'avion' => $avion,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_avion_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Avion $avion, AvionRepository $avionRepository): Response
    {
        $form = $this->createForm(AvionType::class, $avion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $avionRepository->save($avion, true);

            return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('avion/edit.html.twig', [
            'avion' => $avion,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_avion_delete', methods: ['POST'])]
    public function delete(Request $request, Avion $avion, AvionRepository $avionRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $avion->getId(), $request->request->get('_token'))) {
            $avionRepository->remove($avion, true);
        }

        return $this->redirectToRoute('app_avion_index', [], Response::HTTP_SEE_OTHER);
    }
}
