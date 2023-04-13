<?php

namespace App\Controller;

use App\Entity\Gasto;
use App\Entity\Tesorero;
use App\Entity\Usuario;
use App\Form\GastoExportType;
use App\Form\GastoType;
use App\Repository\GastoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/gasto')]
class GastoController extends AbstractController
{
    #[Route('/', name: 'app_gasto_index', methods: ['GET'])]
    public function index(Request $request,GastoRepository $gastoRepository, PaginatorInterface $paginator): Response
    {
        /** @var Usuario $currentUser */
        $currentUser = $this->getUser();
        /** @var Tesorero $tesorero */
        $tesorero = $currentUser->getTesorero();

        $gastosQuery = $gastoRepository->createQueryBuilder('g')->where('g.tesorero = :tesorero')->setParameter('tesorero',$tesorero);

        $query = $gastosQuery->getQuery();

        $gastos = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('gasto/index.html.twig', [
            'gastos' => $gastos,
        ]);
    }

    #[Route('/new', name: 'app_gasto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, GastoRepository $gastoRepository): Response
    {
        $gasto = new Gasto();
        $form = $this->createForm(GastoType::class, $gasto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Usuario $currentUser */
            $currentUser = $this->getUser();
            /** @var Tesorero $tesorero */
            $tesorero = $currentUser->getTesorero();

            if ($tesorero) {
                $gasto->setTesorero($tesorero);
            }
            else {
                throw new \Exception("Usuario a guardar no es tesorero");
            }

            $gastoRepository->save($gasto, true);

            return $this->redirectToRoute('app_gasto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gasto/new.html.twig', [
            'gasto' => $gasto,
            'form' => $form,
        ]);
    }

    #[Route('/exportar', name: 'app_gasto_exportar',methods: ['GET', 'POST'])]
    public function exportar(Request $request,GastoRepository $gastoRepository, SerializerInterface $serializer): Response
    {
        $form = $this->createForm(GastoExportType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            /** @var \DateTimeInterface $fechaInicio */
            $fechaInicio = $data['fecha_inicio'];
            /** @var \DateTimeInterface $fechaFin */
            $fechaFin = $data['fecha_fin'];

            $tesorero = $this->getUserTesorero();

            $gastos = $gastoRepository->createQueryBuilder('g')
                ->where('g.fecha BETWEEN :fecha_inicio AND :fecha_fin')
                ->andWhere('g.tesorero = :tesorero')
                ->setParameter('fecha_inicio',$fechaInicio->format('Y-m-d'))
                ->setParameter('fecha_fin',$fechaFin->format('Y-m-d'))
                ->setParameter('tesorero',$tesorero)
                ->getQuery()->getResult();

            $csvContent = $serializer->serialize($gastos,'csv', [
                DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'
            ]);

            $fileName = 'ListadoGastos.csv';
            $response = new Response($csvContent);
            $disposition = $response->headers->makeDisposition(
                ResponseHeaderBag::DISPOSITION_ATTACHMENT,
                $fileName
            );

            $response->headers->set('Content-Disposition',$disposition);
            return $response;
        }

        return $this->render('gasto/exportar.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gasto_show', methods: ['GET'])]
    public function show(Gasto $gasto): Response
    {
        return $this->render('gasto/show.html.twig', [
            'gasto' => $gasto,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_gasto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Gasto $gasto, GastoRepository $gastoRepository): Response
    {
        $form = $this->createForm(GastoType::class, $gasto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gastoRepository->save($gasto, true);

            return $this->redirectToRoute('app_gasto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('gasto/edit.html.twig', [
            'gasto' => $gasto,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_gasto_delete', methods: ['POST'])]
    public function delete(Request $request, Gasto $gasto, GastoRepository $gastoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gasto->getId(), $request->request->get('_token'))) {
            $gastoRepository->remove($gasto, true);
        }

        return $this->redirectToRoute('app_gasto_index', [], Response::HTTP_SEE_OTHER);
    }

    private function getUserTesorero()
    {
        /** @var Usuario $currentUser */
        $currentUser = $this->getUser();
        /** @var Tesorero $tesorero */
        $tesorero = $currentUser->getTesorero();

        return $tesorero;

    }
}
