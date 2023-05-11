<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\MovimientoStock;
use App\Entity\VueloPlaneador;
use App\Form\VueloPlaneadorType;
use App\Repository\MovimientoStockRepository;
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
        $usuario = $this->getUser();
        $vueloPlaneadorQuery = $vueloPlaneadorRepository->createQueryBuilder('vp')->join('vp.vuelo', 'v');

        if ($this->isGranted('ROLE_ALUMNO')) {

            $vueloPlaneadorQuery
                ->join('v.curso', 'c')
                ->where('c.alumno = :alumno')
                ->setParameter('alumno', $usuario);
        }

        if ($this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_SOCIO')) {

            $vueloPlaneadorQuery->join('v.reservaVuelo','rv')
                ->join('rv.reserva','r')
                ->where('r.usuario = :usuario')
                ->setParameter('usuario',$usuario);
        }

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
    public function new(Request $request, VueloPlaneadorRepository $vueloPlaneadorRepository,  MovimientoStockRepository $movimientoStockRepository): Response
    {
        $isAlumno = $this->isGranted('ROLE_ALUMNO');

        if ($isAlumno) {
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
        }

        $vueloPlaneador = new VueloPlaneador();
        $form = $this->createForm(VueloPlaneadorType::class, $vueloPlaneador,[
            'tipo_usuario' => $this->getUser()->getRoles()[0],
            'usuario' => $this->getUser()
        ]);

        $isSocioPiloto = $this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_SOCIO');

        if ($isSocioPiloto) {
            $formVuelo = $form->get('vuelo');
            $formVuelo->remove('curso');
            $formVuelo->remove('avion');
        }

        if ($isAlumno) {
            $formVuelo = $form->get('vuelo');
            $formVuelo->remove('reservaVuelo');
            $formVuelo->remove('productoVuelos');
            $formVuelo->remove('es_vuelo_turistico');
        }

        $form->handleRequest($request);

        $movimientosStocks = [];
        if ($form->isSubmitted() && $form->isValid()) {

            $vueloPlaneador->getVuelo()->setEsVueloTuristico(false);

            // Realizar movimiento stock si existen
            $productosCargados = $vueloPlaneador->getVuelo()->getProductoVuelos();
            foreach ($productosCargados as $productoCargado) {

                $entrada = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockEntrada')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Entrada'")
                    ->setParameter('producto',$productoCargado->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $salida = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockSalida')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Salida'")
                    ->setParameter('producto',$productoCargado->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $stockEntrada = $entrada ?? 0;
                $stockSalida = $salida ?? 0;

                if ($productoCargado->getCantidad() > ($stockEntrada - $stockSalida)) {
                    $this->addFlash(
                        'error',
                        sprintf("No hay %s cantidades del producto %s para sacar del stock, hay disponibles %s",
                            $productoCargado->getCantidad(),$productoCargado->getProducto()->getDescripcion(),$stockEntrada - $stockSalida)
                    );
                    return $this->redirectToRoute('app_vuelo_planeador_index');
                }

                $movimientoStock = new MovimientoStock();
                $movimientoStock->setCantidad($productoCargado->getCantidad());
                $movimientoStock->setTipo('Salida');
                $movimientoStock->setObservaciones('Movimiento de Salida desde Vuelo del aeroclub');
                $movimientoStock->setProducto($productoCargado->getProducto());

                $movimientosStocks[] = $movimientoStock;

            }

            $vueloPlaneadorRepository->save($vueloPlaneador, true);


            foreach ($movimientosStocks as $movimientosStock){
                $movimientoStockRepository->save($movimientosStock,true);
            }

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
        $form = $this->createForm(VueloPlaneadorType::class, $vueloPlaneador,[
            'tipo_usuario' => $this->getUser()->getRoles()[0],
            'usuario' => $this->getUser()
        ]);
        $isAlumno = $this->isGranted('ROLE_ALUMNO');
        $isSocioPiloto = $this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_SOCIO');

        if ($isSocioPiloto) {
            $formVuelo = $form->get('vuelo');
            $formVuelo->remove('curso');
            $formVuelo->remove('avion');
        }

        if ($isAlumno) {
            $formVuelo = $form->get('vuelo');
            $formVuelo->remove('reservaVuelo');
            $formVuelo->remove('productoVuelos');
            $formVuelo->remove('es_vuelo_turistico');
        }

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
