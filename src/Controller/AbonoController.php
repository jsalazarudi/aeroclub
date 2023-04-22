<?php

namespace App\Controller;

use App\Entity\Abono;
use App\Entity\Alumno;
use App\Entity\ListaPrecio;
use App\Entity\Socio;
use App\Entity\Tesorero;
use App\Entity\Usuario;
use App\Form\AbonoType;
use App\Repository\AbonoRepository;
use App\Repository\CuentaCorrienteRepository;
use App\Repository\ListaPrecioRepository;
use App\Repository\ReservaHangarRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/abono')]
class AbonoController extends AbstractController
{
    #[Route('/', name: 'app_abono_index', methods: ['GET'])]
    public function index(Request $request,AbonoRepository $abonoRepository,PaginatorInterface $paginator): Response
    {
        $abonosQuery = null;
        $isTesorero = $this->isGranted('ROLE_TESORERO');

        if ($isTesorero) {
            $abonosQuery = $abonoRepository->createQueryBuilder('a');
        }

        $isSocioPiloto = $this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO');

        if ($isSocioPiloto && !$isTesorero) {
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
        $form = $this->createForm(AbonoType::class, $abono,[
            'tipo_usuario' => $this->getUser()->getRoles()[0],
            'usuario' => $this->getTipoUsuario()
        ]);

        if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO')) {
            $form->remove('aprobado');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $totalAbono = 0;
            foreach ($abono->getReservasHangar() as $reservaHangar) {

                $servicio = $reservaHangar->getServicio();

                $listaPrecioQuery = $listaPrecioRepository->createQueryBuilder('lp')
                    ->select('lp','MAX(historial.fecha) AS HIDDEN fecha')
                    ->join('lp.servicio','servicio')
                    ->join('lp.historial_lista_precio','historial')
                    ->where('servicio = :servicio')
                    ->setParameter('servicio',$servicio)
                    ->groupBy('lp.id');


                if ($this->isGranted('ROLE_SOCIO')) {
                    $listaPrecioQuery->andWhere('lp.socio = true');
                }
                else {
                    $listaPrecioQuery->andWhere('lp.socio = false OR lp.socio IS NULL');
                }

                /** @var ListaPrecio $listaPrecio */
                $listaPrecio = $listaPrecioQuery->getQuery()->getSingleResult();
                $totalAbono += $listaPrecio->getPrecio() * $reservaHangar->getUnidadesGastadas();

                $reservaHangar->setAbono($abono);
                $reservaHangar->setListaPrecio($listaPrecio);
            }

            $abono->setValor($totalAbono);

            if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO')) {
                $abono->setAprobado(false);
            }

            if ($this->isGranted('ROLE_SOCIO')) {
                $abono->setSocio($this->getUser()->getSocio());
            } elseif ($this->isGranted('ROLE_PILOTO')) {
                $abono->setPiloto($this->getUser()->getPiloto());
            } elseif ($this->isGranted('ROLE_TESORERO')) {
                $abono->setTesorero($this->getUser()->getTesorero());
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
            $form->remove('fecha');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $abonoRepository->save($abono, true);

            return $this->redirectToRoute('app_abono_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('abono/edit.html.twig', [
            'abono' => $abono,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_abono_delete', methods: ['POST'])]
    public function delete(Request $request, Abono $abono, AbonoRepository $abonoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$abono->getId(), $request->request->get('_token'))) {
            $abonoRepository->remove($abono, true);
        }

        return $this->redirectToRoute('app_abono_index', [], Response::HTTP_SEE_OTHER);
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
