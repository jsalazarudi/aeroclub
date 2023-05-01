<?php

namespace App\Controller;

use App\Entity\Abono;
use App\Entity\Alumno;
use App\Entity\ListaPrecio;
use App\Entity\Socio;
use App\Entity\Usuario;
use App\Form\AbonoType;
use App\Repository\AbonoRepository;
use App\Repository\ListaPrecioRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Dompdf\Dompdf;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/abono')]
class AbonoController extends AbstractController
{
    #[Route('/', name: 'app_abono_index', methods: ['GET'])]
    public function index(Request $request, AbonoRepository $abonoRepository, PaginatorInterface $paginator): Response
    {
        $abonosQuery = null;
        $isTesorero = $this->isGranted('ROLE_TESORERO');

        if ($isTesorero) {
            $abonosQuery = $abonoRepository->createQueryBuilder('a');
        }

        $isSocioPilotoAlumno = $this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO')
            || $this->isGranted('ROLE_ALUMNO');

        if ($isSocioPilotoAlumno && !$isTesorero) {
            $tipoUsuario = $this->getTipoUsuario();
            $abonosQuery = $abonoRepository->createQueryBuilder('a');

            if ($this->isGranted('ROLE_SOCIO')) {
                $abonosQuery->where('a.socio = :socio')
                    ->setParameter('socio', $tipoUsuario);
            } elseif ($this->isGranted('ROLE_PILOTO')) {
                $abonosQuery->where('a.piloto = :piloto')
                    ->setParameter('piloto', $tipoUsuario);
            } elseif ($this->isGranted('ROLE_ALUMNO')) {
                $abonosQuery->where('a.alumno = :alumno')
                    ->setParameter('alumno', $tipoUsuario);
            }
        }

        $query = $abonosQuery->getQuery();

        $abonos = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('abono/index.html.twig', [
            'abonos' => $abonos,
        ]);
    }

    #[Route('/new', name: 'app_abono_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AbonoRepository $abonoRepository, ListaPrecioRepository $listaPrecioRepository): Response
    {

        $abono = new Abono();
        $form = $this->createForm(AbonoType::class, $abono, [
            'tipo_usuario' => $this->getUser()->getRoles()[0],
            'usuario' => $this->getTipoUsuario()
        ]);

        if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_ALUMNO')) {
            $form->remove('aprobado');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var string $ultimaFechaHistorialListaPrecios */
            $ultimaFechaHistorialListaPrecios = $listaPrecioRepository->createQueryBuilder('lp')
                ->join('lp.historial_lista_precio', 'hlp')
                ->select('MAX(hlp.fecha) AS fecha')
                ->getQuery()
                ->getSingleScalarResult();

            // VALIDACION RESERVAS HANGAR
            $totalAbono = 0;
            foreach ($abono->getReservasHangar() as $reservaHangar) {

                $servicio = $reservaHangar->getServicio();

                $listaPrecioQuery = $listaPrecioRepository->createQueryBuilder('lp')
                    ->join('lp.servicio', 'servicio')
                    ->join('lp.historial_lista_precio', 'historial')
                    ->where('servicio = :servicio')
                    ->andWhere('historial.fecha = :fecha')
                    ->setParameter('servicio', $servicio)
                    ->setParameter('fecha', $ultimaFechaHistorialListaPrecios);

                if ($this->isGranted('ROLE_SOCIO')) {
                    $listaPrecioQuery->andWhere('lp.socio = true');
                } else {
                    $listaPrecioQuery->andWhere('lp.socio = false OR lp.socio IS NULL');
                }

                /** @var ListaPrecio $listaPrecio */
                $listaPrecio = $listaPrecioQuery->getQuery()->getSingleResult();
                $totalAbono += $listaPrecio->getPrecio() * $reservaHangar->getUnidadesGastadas();

                $reservaHangar->setAbono($abono);
                $reservaHangar->setListaPrecio($listaPrecio);
            }

            // VALIDACION VUELOS
            foreach ($abono->getMovimientoCuentaVuelos() as $movimientoCuentaVuelo) {

                $avion = $movimientoCuentaVuelo->getVuelo()->getAvion();
                if (!$avion) {
                    $avion = $movimientoCuentaVuelo->getVuelo()->getReservaVuelo()->getAvion();
                }

                $listaPrecioQuery = $listaPrecioRepository->createQueryBuilder('lp')
                    ->join('lp.historial_lista_precio', 'historial')
                    ->where('lp.avion = :avion')
                    ->andWhere('historial.fecha = :fecha')
                    ->setParameter('avion', $avion)
                    ->setParameter('fecha', $ultimaFechaHistorialListaPrecios);

                if ($this->isGranted('ROLE_ALUMNO')) {
                    $listaPrecioQuery->andWhere('lp.alumno = true');
                }

                // VALIDAR SI ES UN VUELO TURISMO
                if($movimientoCuentaVuelo->getVuelo()->isEsVueloTuristico()) {
                    $listaPrecioQuery->andWhere('lp.bautismo = true');
                }
                else {
                    $listaPrecioQuery->andWhere('lp.socio = true');
                }

                /** @var ListaPrecio $listaPrecio */
                try {
                    $listaPrecio = $listaPrecioQuery->getQuery()->getSingleResult();
                } catch (NoResultException $e) {
                    $this->addFlash(
                        'error',
                        'No hay lista de precios relacionadas'
                    );
                    return $this->render('abono/new.html.twig', [
                        'abono' => $abono,
                        'form' => $form,
                    ]);

                } catch (NonUniqueResultException $e){
                    $this->addFlash(
                        'error',
                        'Hay conflicto entre dos listas de precios'
                    );
                    return $this->render('abono/new.html.twig', [
                        'abono' => $abono,
                        'form' => $form,
                    ]);
                }

                $totalAbono += $listaPrecio->getPrecio() * $movimientoCuentaVuelo->getUnidadesGastadas();

                $movimientoCuentaVuelo->setAbono($abono);
                $movimientoCuentaVuelo->setListaPrecio($listaPrecio);

            }

            // VALIDACION VENTAS
            foreach ($abono->getVentas() as $venta) {
                foreach ($venta->getProductoVentas() as $producto) {
                    $listaPrecioQuery = $listaPrecioRepository->createQueryBuilder('lp')
                        ->join('lp.historial_lista_precio', 'historial')
                        ->where('lp.producto = :producto')
                        ->andWhere('historial.fecha = :fecha')
                        ->setParameter('producto', $producto->getProducto())
                        ->setParameter('fecha', $ultimaFechaHistorialListaPrecios);

                    if ($this->isGranted('ROLE_SOCIO')) {
                        $listaPrecioQuery->andWhere('lp.socio = true');
                    }

                    /** @var ListaPrecio $listaPrecio */
                    $listaPrecio = $listaPrecioQuery->getQuery()->getSingleResult();
                    $totalAbono += $listaPrecio->getPrecio() * $producto->getCantidad();

                    $producto->setListaPrecio($listaPrecio);
                }

                $venta->setAbono($abono);
            }

            $abono->setValor($totalAbono);

            if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_ALUMNO')) {
                $abono->setAprobado(false);
            }

            if ($this->isGranted('ROLE_SOCIO')) {
                $abono->setSocio($this->getUser()->getSocio());
            } elseif ($this->isGranted('ROLE_PILOTO')) {
                $abono->setPiloto($this->getUser()->getPiloto());
            } elseif ($this->isGranted('ROLE_TESORERO')) {
                $abono->setTesorero($this->getUser()->getTesorero());
            } elseif ($this->isGranted('ROLE_ALUMNO')) {
                $abono->setAlumno($this->getUser()->getAlumno());
            }

            $abonoRepository->save($abono, true);

            return $this->redirectToRoute('app_abono_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('abono/new.html.twig', [
            'abono' => $abono,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_abono_show', methods: ['GET'])]
    public function show(Abono $abono): Response
    {
        return $this->render('abono/show.html.twig', [
            'abono' => $abono,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_abono_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Abono $abono, AbonoRepository $abonoRepository): Response
    {
        $form = $this->createForm(AbonoType::class, $abono);

        if ($this->isGranted('ROLE_TESORERO')) {
            $form->remove('reservasHangar');
            $form->remove('movimientoCuentaVuelos');
            $form->remove('ventas');
            $form->remove('fecha');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonoRepository->save($abono, true);

            return $this->redirectToRoute('app_abono_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('abono/edit.html.twig', [
            'abono' => $abono,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_abono_delete', methods: ['POST'])]
    public function delete(Request $request, Abono $abono, AbonoRepository $abonoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $abono->getId(), $request->request->get('_token'))) {
            $abonoRepository->remove($abono, true);
        }

        return $this->redirectToRoute('app_abono_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/recibo',name: 'app_abono_recibo',methods: ['GET'])]
    public function recibo(Request $request, Abono $abono): Response
    {
        $usuario = null;
        if ($this->isGranted('ROLE_PILOTO')) {
            $usuario = $this->getUser()->getPiloto();
        }

        if ( $this->isGranted('ROLE_SOCIO')) {
            $usuario = $this->getUser()->getSocio();
        }

        $total = $abono->getValor();

        $reservasHangar = $abono->getReservasHangar();
        $vuelos = $abono->getMovimientoCuentaVuelos();
        $ventas = $abono->getVentas();


        $html = $this->renderView('abono/recibo.html.twig',[
            'logoAeroclob' => $this->imageToBase64(),
            'usuario' => $usuario,
            'total' => $total,
            'vuelos' => $vuelos,
            'ventas' => $ventas,
            'reservasHangar' => $reservasHangar
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->render();

        return new Response(
            $dompdf->stream('Recibo',['Attachment' => false]),
            Response::HTTP_OK,
            ['Content-Type' => 'application/pdf']
        );
    }

    private function imageToBase64()
    {
        $path = $this->getParameter('kernel.project_dir').'/public/Logoaeroclub.png';
        $type = pathinfo($path, PATHINFO_EXTENSION);
        $data = file_get_contents($path);
        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
        return $base64;
    }

    /**
     * @return Piloto|Socio|Alumno
     */
    private function getTipoUsuario()
    {
        /** @var Usuario $currentUser */
        $currentUser = $this->getUser();
        /** @var Socio|Piloto|Alumno $tipoUsuario */
        $tipoUsuario = $currentUser->getSocio() ?? $currentUser->getPiloto() ?? $currentUser->getAlumno();

        return $tipoUsuario;

    }
}
