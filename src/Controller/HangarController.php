<?php

namespace App\Controller;

use App\Entity\Hangar;
use App\Form\HangarType;
use App\Repository\HangarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/hangar')]
class HangarController extends AbstractController
{
    #[Route('/', name: 'app_hangar_index', methods: ['GET'])]
    public function index(Request $request,HangarRepository $hangarRepository,PaginatorInterface $paginator): Response
    {
        $reservasQuery = $hangarRepository->createQueryBuilder('r');

        $query = $reservasQuery->getQuery();

        $hangares = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('hangar/index.html.twig', [
            'hangars' => $hangares,
        ]);
    }

    #[Route('/new', name: 'app_hangar_new', methods: ['GET', 'POST'])]
    public function new(Request $request, HangarRepository $hangarRepository): Response
    {
        $hangar = new Hangar();
        $form = $this->createForm(HangarType::class, $hangar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hangarRepository->save($hangar, true);

            return $this->redirectToRoute('app_hangar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hangar/new.html.twig', [
            'hangar' => $hangar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hangar_show', methods: ['GET'])]
    public function show(Hangar $hangar): Response
    {
        return $this->render('hangar/show.html.twig', [
            'hangar' => $hangar,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_hangar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Hangar $hangar, HangarRepository $hangarRepository): Response
    {
        $form = $this->createForm(HangarType::class, $hangar);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $hangarRepository->save($hangar, true);

            return $this->redirectToRoute('app_hangar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('hangar/edit.html.twig', [
            'hangar' => $hangar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_hangar_delete', methods: ['POST'])]
    public function delete(Request $request, Hangar $hangar, HangarRepository $hangarRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$hangar->getId(), $request->request->get('_token'))) {
            $hangarRepository->remove($hangar, true);
        }

        return $this->redirectToRoute('app_hangar_index', [], Response::HTTP_SEE_OTHER);
    }
}
