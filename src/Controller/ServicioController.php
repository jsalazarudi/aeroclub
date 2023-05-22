<?php

namespace App\Controller;

use App\Entity\Servicio;
use App\Form\ServicioType;
use App\Repository\ServicioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/servicio')]
class ServicioController extends AbstractController
{
    #[Route('/', name: 'app_servicio_index', methods: ['GET'])]
    public function index(Request $request,ServicioRepository $servicioRepository, PaginatorInterface $paginator): Response
    {
        $serviciosQuery = $servicioRepository->createQueryBuilder('s');

        $query = $serviciosQuery->getQuery();

        $servicios = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('servicio/index.html.twig', [
            'servicios' => $servicios,
        ]);
    }

    #[Route('/new', name: 'app_servicio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ServicioRepository $servicioRepository): Response
    {
        $servicio = new Servicio();
        $form = $this->createForm(ServicioType::class, $servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($servicio->isDefecto()) {
                if ($servicio->isEsHangaraje() && $servicio->isEsMensual()) {
                    $this->addFlash(
                        'error',
                        'Solo se puede seleccionar defecto o pago mensual al mismo tiempo'
                    );
                    return $this->render('servicio/new.html.twig', [
                        'servicio' => $servicio,
                        'form' => $form,
                    ]);
                }
            }

            $servicioRepository->save($servicio, true);

            return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('servicio/new.html.twig', [
            'servicio' => $servicio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_servicio_show', methods: ['GET'])]
    public function show(Servicio $servicio): Response
    {
        return $this->render('servicio/show.html.twig', [
            'servicio' => $servicio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_servicio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Servicio $servicio, ServicioRepository $servicioRepository): Response
    {
        $form = $this->createForm(ServicioType::class, $servicio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($servicio->isDefecto()) {
                if ($servicio->isEsHangaraje() && $servicio->isEsMensual()) {
                    $this->addFlash(
                        'error',
                        'Solo se puede seleccionar defecto o pago mensual al mismo tiempo'
                    );
                    return $this->render('servicio/edit.html.twig', [
                        'servicio' => $servicio,
                        'form' => $form,
                    ]);
                }
            }

            $servicioRepository->save($servicio, true);

            return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('servicio/edit.html.twig', [
            'servicio' => $servicio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_servicio_delete', methods: ['POST'])]
    public function delete(Request $request, Servicio $servicio, ServicioRepository $servicioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$servicio->getId(), $request->request->get('_token'))) {
            $servicioRepository->remove($servicio, true);
        }

        return $this->redirectToRoute('app_servicio_index', [], Response::HTTP_SEE_OTHER);
    }
}
