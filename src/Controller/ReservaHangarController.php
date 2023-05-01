<?php

namespace App\Controller;

use App\Entity\Mensualidad;
use App\Entity\ReservaHangar;
use App\Entity\Socio;
use App\Entity\Tesorero;
use App\Entity\Usuario;
use App\Form\ReservaHangarType;
use App\Repository\MensualidadRepository;
use App\Repository\ReservaHangarRepository;
use App\Repository\ServicioRepository;
use App\Repository\SocioRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reserva/hangar')]
class ReservaHangarController extends AbstractController
{
    #[Route('/', name: 'app_reserva_hangar_index', methods: ['GET'])]
    public function index(Request $request, ReservaHangarRepository $reservaHangarRepository, PaginatorInterface $paginator): Response
    {
        $reservasHangarQuery = null;
        $isTesorero = $this->isGranted('ROLE_TESORERO');

        if ($isTesorero) {
            $reservasHangarQuery = $reservaHangarRepository->createQueryBuilder('rh')
                ->join('rh.reserva', 'r');
        }

        $isSocioPiloto = $this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO');

        if ($isSocioPiloto && !$isTesorero) {
            $tipoUsuario = $this->getTipoUsuario();
            $reservasHangarQuery = $reservaHangarRepository->createQueryBuilder('rh')
                ->join('rh.reserva', 'r');

            if ($this->isGranted('ROLE_SOCIO')) {
                $reservasHangarQuery->where('r.socio = :socio')
                    ->setParameter('socio', $tipoUsuario);
            } elseif ($this->isGranted('ROLE_PILOTO')) {

                $reservasHangarQuery->where('r.piloto = :piloto')
                    ->setParameter('piloto', $tipoUsuario);
            }
        }

        $query = $reservasHangarQuery->getQuery();

        $reservasHangar = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('reserva_hangar/index.html.twig', [
            'reservas' => $reservasHangar,
        ]);
    }

    #[Route('/new', name: 'app_reserva_hangar_new', methods: ['GET', 'POST'])]
    public function new(Request         $request, ReservaHangarRepository $reservaHangarRepository,
                        SocioRepository $socioRepository, ServicioRepository $servicioRepository, MensualidadRepository $mensualidadRepository): Response
    {
        $reservaHangar = new ReservaHangar();

        $form = $this->createForm(ReservaHangarType::class, $reservaHangar);

        if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO')) {
            $form->remove('unidades_gastadas');
            $reservaForm = $form->get('reserva');
            $reservaForm->remove('aprobado');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $tipoUsuario = $this->getTipoUsuario();
            if ($this->isGranted('ROLE_SOCIO')) {
                $reservaHangar->getReserva()->setSocio($tipoUsuario);

                $mensualidadQuery = $mensualidadRepository->createQueryBuilder('m')
                    ->join('m.servicio','s')
                    ->where('m.socio = :socio')
                    ->andWhere('s.es_hangaraje = true')
                    ->andWhere('m.fecha_fin > :fecha_fin')
                    ->andWhere('m.fecha_inicio < :fecha_inicio')
                    ->setParameter('socio',$tipoUsuario)
                    ->setParameter('fecha_inicio',$reservaHangar->getReserva()->getFechaInicio()->format('Y-m-d H:i:s'))
                    ->setParameter('fecha_fin',$reservaHangar->getReserva()->getFechaFin()->format('Y-m-d H:i:s'))
                    ->getQuery();

                try {
                    /** @var Mensualidad $resultMensualidadQuery */
                    $resultMensualidadQuery = $mensualidadQuery->getSingleResult();
                } catch (NoResultException $e) {
                    $servicio = $servicioRepository->createQueryBuilder('s')
                        ->where('s.es_hangaraje = true')
                        ->andWhere('s.defecto = true')
                        ->getQuery()
                        ->getSingleResult();

                    $reservaHangar->setServicio($servicio);
                } catch (NonUniqueResultException $e) {
                }

                $reservaHangar->setServicio($resultMensualidadQuery->getServicio());

            } elseif ($this->isGranted('ROLE_PILOTO')) {
                $reservaHangar->getReserva()->setPiloto($tipoUsuario);

                $servicio = $servicioRepository->createQueryBuilder('s')
                    ->where('s.es_hangaraje = true')
                    ->andWhere('s.defecto = true')
                    ->getQuery()
                    ->getSingleResult();

                $reservaHangar->setServicio($servicio);
            }

            $reservaHangarRepository->save($reservaHangar, true);

            return $this->redirectToRoute('app_reserva_hangar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reserva_hangar/new.html.twig', [
            'reserva_hangar' => $reservaHangar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reserva_hangar_show', methods: ['GET'])]
    public function show(ReservaHangar $reservaHangar): Response
    {
        return $this->render('reserva_hangar/show.html.twig', [
            'reserva_hangar' => $reservaHangar,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reserva_hangar_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservaHangar $reservaHangar, ReservaHangarRepository $reservaHangarRepository): Response
    {
        $form = $this->createForm(ReservaHangarType::class, $reservaHangar);

        if ($this->isGranted("ROLE_TESORERO")) {
            $form->remove('dias_ocupacion');
            $form->remove('hangar');
            $formReserva = $form->get('reserva');
            $formReserva->remove('fecha_inicio');
            $formReserva->remove('fecha_fin');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservaHangarRepository->save($reservaHangar, true);

            return $this->redirectToRoute('app_reserva_hangar_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reserva_hangar/edit.html.twig', [
            'reserva_hangar' => $reservaHangar,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reserva_hangar_delete', methods: ['POST'])]
    public function delete(Request $request, ReservaHangar $reservaHangar, ReservaHangarRepository $reservaHangarRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservaHangar->getId(), $request->request->get('_token'))) {
            $reservaHangarRepository->remove($reservaHangar, true);
        }

        return $this->redirectToRoute('app_reserva_hangar_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @return Piloto|Socio|Tesorero
     */
    private function getTipoUsuario()
    {
        /** @var Usuario $currentUser */
        $currentUser = $this->getUser();
        /** @var Socio|Piloto|Tesorero $tipoUsuario */
        $tipoUsuario = $currentUser->getSocio() ?? $currentUser->getPiloto() ?? $currentUser->getTesorero();

        return $tipoUsuario;

    }
}