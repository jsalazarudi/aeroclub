<?php

namespace App\Controller;

use App\Entity\Mensualidad;
use App\Form\MensualidadType;
use App\Repository\MensualidadRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/mensualidad')]
class MensualidadController extends AbstractController
{
    #[Route('/', name: 'app_mensualidad_index', methods: ['GET'])]
    public function index(Request $request,MensualidadRepository $mensualidadRepository,PaginatorInterface $paginator): Response
    {
        $mensualidadesQuery = $mensualidadRepository->createQueryBuilder('m');

        $query = $mensualidadesQuery->getQuery();

        $mensualidades = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('mensualidad/index.html.twig', [
            'mensualidades' => $mensualidades,
        ]);
    }

    #[Route('/new', name: 'app_mensualidad_new', methods: ['GET', 'POST'])]
    public function new(Request $request, MensualidadRepository $mensualidadRepository): Response
    {
        $mensualidad = new Mensualidad();
        $form = $this->createForm(MensualidadType::class, $mensualidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mensualidadRepository->save($mensualidad, true);

            return $this->redirectToRoute('app_mensualidad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mensualidad/new.html.twig', [
            'mensualidad' => $mensualidad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mensualidad_show', methods: ['GET'])]
    public function show(Mensualidad $mensualidad): Response
    {
        return $this->render('mensualidad/show.html.twig', [
            'mensualidad' => $mensualidad,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_mensualidad_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Mensualidad $mensualidad, MensualidadRepository $mensualidadRepository): Response
    {
        $form = $this->createForm(MensualidadType::class, $mensualidad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mensualidadRepository->save($mensualidad, true);

            return $this->redirectToRoute('app_mensualidad_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('mensualidad/edit.html.twig', [
            'mensualidad' => $mensualidad,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_mensualidad_delete', methods: ['POST'])]
    public function delete(Request $request, Mensualidad $mensualidad, MensualidadRepository $mensualidadRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$mensualidad->getId(), $request->request->get('_token'))) {
            $mensualidadRepository->remove($mensualidad, true);
        }

        return $this->redirectToRoute('app_mensualidad_index', [], Response::HTTP_SEE_OTHER);
    }
}
