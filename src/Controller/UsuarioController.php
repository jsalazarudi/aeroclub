<?php

namespace App\Controller;

use App\Repository\VueloMotorRepository;
use App\Repository\VueloPlaneadorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario')]
class UsuarioController extends AbstractController
{
    #[Route('/', name: 'app_usuario_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('usuario/listado.html.twig');
    }

    #[Route('/listado/vuelo_turistico/motor', name: 'app_listado_vuelos_turisticos_motor', methods: ['GET'])]
    public function listadoVuelosTuristicosMotor(Request $request,VueloMotorRepository $vueloMotorRepository, PaginatorInterface $paginator): Response
    {
        if (!$this->isGranted('ROLE_TESORERO')) {
            $this->addFlash('error','No tiene permiso de acceder a esta ruta');
            return $this->redirectToRoute('app_vuelo_planeador_index', [], Response::HTTP_SEE_OTHER);
        }

        $vuelosMotorQuery = $vueloMotorRepository->createQueryBuilder('vm')
            ->join('vm.vuelo', 'v')
            ->where('v.es_vuelo_turistico = true');

        $query = $vuelosMotorQuery->getQuery();

        $vuelosMotor = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('tesorero/listado_vuelo_turisticos_motor.html.twig', [
            'vuelos_motor' => $vuelosMotor,
        ]);
    }

    #[Route('/listado/vuelo_turistico/planeador', name: 'app_listado_vuelos_turisticos_planeador', methods: ['GET'])]
    public function listadoVuelosTuristicosPlaneador(Request $request, VueloPlaneadorRepository $vueloPlaneadorRepository, PaginatorInterface $paginator): Response
    {
        if (!$this->isGranted('ROLE_TESORERO')) {
            $this->addFlash('error','No tiene permiso de acceder a esta ruta');
            return $this->redirectToRoute('app_vuelo_planeador_index', [], Response::HTTP_SEE_OTHER);
        }

        $vueloPlaneadorQuery = $vueloPlaneadorRepository->createQueryBuilder('vp')
            ->join('vp.vuelo', 'v')
            ->where('v.es_vuelo_turistico = true');

        $query = $vueloPlaneadorQuery->getQuery();

        $vuelosPlaneador = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('tesorero/listado_vuelo_turisticos_planeador.html.twig',[
            'vuelos_planeador' => $vuelosPlaneador
        ]);
    }
}
