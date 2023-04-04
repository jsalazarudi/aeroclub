<?php

namespace App\Controller;

use App\Entity\Socio;
use App\Form\SocioType;
use App\Repository\SocioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/socio')]
class SocioController extends AbstractController
{
    #[Route('/', name: 'aeroclub_socio_index', methods: ['GET'])]
    public function index(Request $request, SocioRepository $socioRepository, PaginatorInterface $paginator): Response
    {
        $sociosActivos = $socioRepository->createQueryBuilder('s')->andWhere('s.activo = true');
        $query = $sociosActivos->getQuery();

        $socios = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('socio/index.html.twig', [
            'socios' => $socios,
        ]);
    }

    #[Route('/new', name: 'aeroclub_socio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocioRepository $socioRepository): Response
    {
        $socio = new Socio();
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socio->setActivo(true);
            $socioRepository->save($socio, true);

            return $this->redirectToRoute('aeroclub_socio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('socio/new.html.twig', [
            'socio' => $socio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_socio_show', methods: ['GET'])]
    public function show(Socio $socio): Response
    {
        return $this->render('socio/show.html.twig', [
            'socio' => $socio,
        ]);
    }

    #[Route('/{id}/edit', name: 'aeroclub_socio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Socio $socio, SocioRepository $socioRepository): Response
    {
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $socioRepository->save($socio, true);

            return $this->redirectToRoute('aeroclub_socio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('socio/edit.html.twig', [
            'socio' => $socio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_socio_delete', methods: ['POST'])]
    public function delete(Request $request, Socio $socio, SocioRepository $socioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $socio->getId(), $request->request->get('_token'))) {
            $socio->setActivo(false);
            $socioRepository->save($socio, true);
        }

        return $this->redirectToRoute('aeroclub_socio_index', [], Response::HTTP_SEE_OTHER);
    }
}
