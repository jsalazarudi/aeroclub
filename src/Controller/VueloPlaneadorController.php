<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\VueloPlaneador;
use App\Form\VueloPlaneadorType;
use App\Repository\VueloPlaneadorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vuelo/planeador')]
class VueloPlaneadorController extends AbstractController
{
    #[Route('/', name: 'app_vuelo_planeador_index', methods: ['GET'])]
    public function index(Request $request, VueloPlaneadorRepository $vueloPlaneadorRepository, PaginatorInterface $paginator): Response
    {
        /** @var Alumno $alumno */
        $alumno = $this->getUser()->getAlumno();
        $vueloPlaneadorQuery = $vueloPlaneadorRepository->createQueryBuilder('vp')
            ->join('vp.vuelo', 'v')
            ->join('v.curso', 'c')
            ->where('c.alumno = :alumno')
            ->setParameter('alumno', $alumno);

        $query = $vueloPlaneadorQuery->getQuery();

        $vuelosPlaneador = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('vuelo_planeador/index.html.twig', [
            'vuelos_planeador' => $vuelosPlaneador,
        ]);
    }

    #[Route('/new', name: 'app_vuelo_planeador_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VueloPlaneadorRepository $vueloPlaneadorRepository): Response
    {
        /** @var Alumno $alumno */
        $alumno = $this->getUser()->getAlumno();

        if (!$alumno->isHabilitadoVolar()) {
            $this->addFlash(
                'error',
                'Aún no esta habilitado para realizar vuelos. Contactar a un usuario con rol tesorero o instructor
                para poder registrar vuelos motor'
            );
            return $this->redirectToRoute('app_vuelo_planeador_index', [], Response::HTTP_SEE_OTHER);
        }

        $vueloPlaneador = new VueloPlaneador();
        $form = $this->createForm(VueloPlaneadorType::class, $vueloPlaneador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vueloPlaneadorRepository->save($vueloPlaneador, true);

            return $this->redirectToRoute('app_vuelo_planeador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vuelo_planeador/new.html.twig', [
            'vuelo_planeador' => $vueloPlaneador,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vuelo_planeador_show', methods: ['GET'])]
    public function show(VueloPlaneador $vueloPlaneador): Response
    {
        return $this->render('vuelo_planeador/show.html.twig', [
            'vuelo_planeador' => $vueloPlaneador,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vuelo_planeador_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VueloPlaneador $vueloPlaneador, VueloPlaneadorRepository $vueloPlaneadorRepository): Response
    {
        $form = $this->createForm(VueloPlaneadorType::class, $vueloPlaneador);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vueloPlaneadorRepository->save($vueloPlaneador, true);

            return $this->redirectToRoute('app_vuelo_planeador_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vuelo_planeador/edit.html.twig', [
            'vuelo_planeador' => $vueloPlaneador,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vuelo_planeador_delete', methods: ['POST'])]
    public function delete(Request $request, VueloPlaneador $vueloPlaneador, VueloPlaneadorRepository $vueloPlaneadorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vueloPlaneador->getId(), $request->request->get('_token'))) {
            $vueloPlaneadorRepository->remove($vueloPlaneador, true);
        }

        return $this->redirectToRoute('app_vuelo_planeador_index', [], Response::HTTP_SEE_OTHER);
    }
}
