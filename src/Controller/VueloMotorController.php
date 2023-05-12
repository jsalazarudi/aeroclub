<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\MovimientoStock;
use App\Entity\VueloMotor;
use App\Form\VueloMotorType;
use App\Repository\MovimientoStockRepository;
use App\Repository\VueloMotorRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/vuelo/motor')]
class VueloMotorController extends AbstractController
{
    #[Route('/', name: 'app_vuelo_motor_index', methods: ['GET'])]
    public function index(Request $request, VueloMotorRepository $vueloMotorRepository, PaginatorInterface $paginator): Response
    {
        $usuario = $this->getUser();

        $vuelosMotorQuery = $vueloMotorRepository->createQueryBuilder('vm')
            ->join('vm.vuelo', 'v');

        if ($this->isGranted('ROLE_ALUMNO')) {
            $vuelosMotorQuery->join('v.curso', 'c')
                ->where('c.alumno = :alumno')
                ->setParameter('alumno', $usuario);
        }

        if ($this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_SOCIO')) {

            $vuelosMotorQuery->join('v.reservaVuelo', 'rv')
                ->join('rv.reserva', 'r')
                ->where('r.usuario = :usuario')
                ->setParameter('usuario', $usuario);
        }

        $query = $vuelosMotorQuery->getQuery();

        $vuelosMotor = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );


        return $this->render('vuelo_motor/index.html.twig', [
            'vuelos_motor' => $vuelosMotor,
        ]);
    }

    #[Route('/new', name: 'app_vuelo_motor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, VueloMotorRepository $vueloMotorRepository, MovimientoStockRepository $movimientoStockRepository): Response
    {
        if ($this->isGranted('ROLE_ALUMNO')) {
            /** @var Alumno $alumno */
            $alumno = $this->getUser()->getAlumno();

            if (!$alumno->isHabilitadoVolar()) {
                $this->addFlash(
                    'error',
                    'Aún no esta habilitado para realizar vuelos. Contactar a un usuario con rol tesorero o instructor
                para poder registrar vuelos motor'
                );
                return $this->redirectToRoute('app_vuelo_motor_index', [], Response::HTTP_SEE_OTHER);
            }
        }

        $vueloMotor = new VueloMotor();
        $form = $this->createForm(VueloMotorType::class, $vueloMotor, [
            'tipo_usuario' => $this->getUser()->getRoles()[0],
            'usuario' => $this->getUser(),
            'is_new' => true
        ]);

        $isSocioPiloto = $this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_SOCIO');

        if ($isSocioPiloto) {
            $formVuelo = $form->get('vuelo');
            $formVuelo->remove('curso');
            $formVuelo->remove('avion');
        }

        if ($this->isGranted('ROLE_ALUMNO')) {
            $formVuelo = $form->get('vuelo');
            $formVuelo->remove('productoVuelos');
            $formVuelo->remove('reservaVuelo');
            $formVuelo->remove('es_vuelo_turistico');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $vueloMotor->getVuelo()->setEsVueloTuristico(false);

            // Realizar validacion stock producto vuelos
            $productosCargados = $vueloMotor->getVuelo()->getProductoVuelos();
            $movimientosStocks = [];
            foreach ($productosCargados as $productoCargado) {

                $entrada = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockEntrada')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Entrada'")
                    ->setParameter('producto', $productoCargado->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $salida = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockSalida')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Salida'")
                    ->setParameter('producto', $productoCargado->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $stockEntrada = $entrada ?? 0;
                $stockSalida = $salida ?? 0;

                if ($productoCargado->getCantidad() > ($stockEntrada - $stockSalida)) {
                    $this->addFlash(
                        'error',
                        sprintf("No hay %s cantidades del producto %s para sacar del stock, hay disponibles %s",
                            $productoCargado->getCantidad(), $productoCargado->getProducto()->getDescripcion(), $stockEntrada - $stockSalida)
                    );
                    return $this->render('vuelo_motor/new.html.twig', [
                        'vuelo_motor' => $vueloMotor,
                        'form' => $form,
                    ]);
                }

                $movimientoStock = new MovimientoStock();
                $movimientoStock->setCantidad($productoCargado->getCantidad());
                $movimientoStock->setTipo('Salida');
                $movimientoStock->setObservaciones('Movimiento de Salida desde Vuelo del aeroclub');
                $movimientoStock->setProducto($productoCargado->getProducto());
                $movimientoStock->setRealizado($this->getUser());

                $movimientosStocks[] = $movimientoStock;

            }

            $vueloMotorRepository->save($vueloMotor, true);

            foreach ($movimientosStocks as $movimientosStock) {
                $movimientoStockRepository->save($movimientosStock, true);
            }

            return $this->redirectToRoute('app_vuelo_motor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vuelo_motor/new.html.twig', [
            'vuelo_motor' => $vueloMotor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vuelo_motor_show', methods: ['GET'])]
    public function show(VueloMotor $vueloMotor): Response
    {
        return $this->render('vuelo_motor/show.html.twig', [
            'vuelo_motor' => $vueloMotor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_vuelo_motor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, VueloMotor $vueloMotor, VueloMotorRepository $vueloMotorRepository, MovimientoStockRepository $movimientoStockRepository): Response
    {
        $form = $this->createForm(VueloMotorType::class, $vueloMotor, [
            'tipo_usuario' => $this->getUser()->getRoles()[0],
            'usuario' => $this->getUser(),
            'is_new' => false
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

            // Realizar validacion stock producto vuelos
            $productosCargados = $vueloMotor->getVuelo()->getProductoVuelos();
            $movimientosStocks = [];
            foreach ($productosCargados as $productoCargado) {

                $entrada = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockEntrada')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Entrada'")
                    ->setParameter('producto', $productoCargado->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $salida = $movimientoStockRepository->createQueryBuilder('m')
                    ->select('SUM(m.cantidad) AS stockSalida')
                    ->where('m.producto = :producto')
                    ->andWhere("m.tipo = 'Salida'")
                    ->setParameter('producto', $productoCargado->getProducto())
                    ->getQuery()->getSingleScalarResult();

                $stockEntrada = $entrada ?? 0;
                $stockSalida = $salida ?? 0;

                if ($productoCargado->getCantidad() > ($stockEntrada - $stockSalida)) {
                    $this->addFlash(
                        'error',
                        sprintf("No hay %s cantidades del producto %s para sacar del stock, hay disponibles %s",
                            $productoCargado->getCantidad(), $productoCargado->getProducto()->getDescripcion(), $stockEntrada - $stockSalida)
                    );
                    return $this->render('vuelo_motor/edit.html.twig', [
                        'vuelo_motor' => $vueloMotor,
                        'form' => $form,
                    ]);
                }

                $movimientoStock = new MovimientoStock();
                $movimientoStock->setCantidad($productoCargado->getCantidad());
                $movimientoStock->setTipo('Salida');
                $movimientoStock->setObservaciones('Movimiento de Salida desde Vuelo del aeroclub');
                $movimientoStock->setProducto($productoCargado->getProducto());
                $movimientoStock->setRealizado($this->getUser());

                $movimientosStocks[] = $movimientoStock;

            }

            $vueloMotorRepository->save($vueloMotor, true);

            foreach ($movimientosStocks as $movimientosStock) {
                $movimientoStockRepository->save($movimientosStock, true);
            }

            return $this->redirectToRoute('app_vuelo_motor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('vuelo_motor/edit.html.twig', [
            'vuelo_motor' => $vueloMotor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_vuelo_motor_delete', methods: ['POST'])]
    public function delete(Request $request, VueloMotor $vueloMotor, VueloMotorRepository $vueloMotorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $vueloMotor->getId(), $request->request->get('_token'))) {
            $vueloMotorRepository->remove($vueloMotor, true);
        }

        return $this->redirectToRoute('app_vuelo_motor_index', [], Response::HTTP_SEE_OTHER);
    }
}
