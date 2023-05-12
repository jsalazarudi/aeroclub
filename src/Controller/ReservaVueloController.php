<?php

namespace App\Controller;

use App\Entity\ReservaVuelo;
use App\Form\ReservaVueloType;
use App\Repository\ReservaVueloRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/reserva/vuelo')]
class ReservaVueloController extends AbstractController
{
    #[Route('/', name: 'app_reserva_vuelo_index', methods: ['GET'])]
    public function index(Request $request, ReservaVueloRepository $reservaVueloRepository, PaginatorInterface $paginator): Response
    {
        $reservasVueloQuery = $reservaVueloRepository->createQueryBuilder('rv')
            ->join('rv.reserva', 'r');

        if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO')) {
            $reservasVueloQuery = $reservaVueloRepository->createQueryBuilder('rv')
                ->join('rv.reserva', 'r')
                ->where('r.usuario = :usuario')
                ->setParameter('usuario', $this->getUser());
        }

        $query = $reservasVueloQuery->getQuery();

        $reservasVuelo = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('reserva_vuelo/index.html.twig', [
            'reserva_vuelos' => $reservasVuelo
        ]);
    }

    #[Route('/new', name: 'app_reserva_vuelo_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ReservaVueloRepository $reservaVueloRepository): Response
    {
        $reservaVuelo = new ReservaVuelo();
        $form = $this->createForm(ReservaVueloType::class, $reservaVuelo);

        if ($this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO')) {
            $reservaForm = $form->get('reserva');
            $reservaForm->remove('aprobado');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $reservaVuelo->getReserva()->setUsuario($this->getUser());

            /** @var \DateTimeInterface $fechaInicio */
            $fechaInicio = $reservaVuelo->getReserva()->getFechaInicio();
            $fechaFin = $reservaVuelo->getReserva()->getFechaFin();

            // Validar que no se crucen con otras reservas aprobadas
            $conflictoVuelos = null;
            try {
                $conflictoVuelos = $reservaVueloRepository->createQueryBuilder('rv')
                    ->join('rv.reserva', 'r')
                    ->where('r.aprobado = true')
                    ->andWhere('rv.avion = :avion')
                    ->andWhere('r.fecha_inicio BETWEEN :fecha_inicio AND :fecha_fin OR r.fecha_fin BETWEEN :fecha_inicio AND :fecha_fin OR r.fecha_inicio < :fecha_inicio AND r.fecha_fin > :fecha_fin')
                    ->setParameter('fecha_inicio', $fechaInicio->format('Y-m-d H:i:s'))
                    ->setParameter('fecha_fin', $fechaFin->format('Y-m-d H:i:s'))
                    ->setParameter('avion', $reservaVuelo->getAvion())
                    ->getQuery()
                    ->getSingleResult();
            } catch (NoResultException $e) {
                $reservaVueloRepository->save($reservaVuelo, true);
                return $this->redirectToRoute('app_reserva_vuelo_index', [], Response::HTTP_SEE_OTHER);

            } catch (NonUniqueResultException $e) {
            }

            $messageFlash = sprintf('El avion %s ya se encuentra con una reserva aprobada entre las %s y %s', $conflictoVuelos->getAvion()->getMatricula(),
                $conflictoVuelos->getReserva()->getFechaInicio()->format('Y-m-d H:i:s'), $conflictoVuelos->getReserva()->getFechaFin()->format('Y-m-d H:i:s'));

            $this->addFlash(
                'error',
                $messageFlash
            );
        }

        return $this->render('reserva_vuelo/new.html.twig', [
            'reserva_vuelo' => $reservaVuelo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reserva_vuelo_show', methods: ['GET'])]
    public function show(ReservaVuelo $reservaVuelo): Response
    {
        return $this->render('reserva_vuelo/show.html.twig', [
            'reserva_vuelo' => $reservaVuelo,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reserva_vuelo_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ReservaVuelo $reservaVuelo, ReservaVueloRepository $reservaVueloRepository): Response
    {
        if ($this->isGranted('ROLE_PILOTO') || $this->isGranted('ROLE_SOCIO')) {
            $this->addFlash('error', 'No tiene permisos de editar la reserva');
            return $this->redirectToRoute('app_reserva_vuelo_index', [], Response::HTTP_SEE_OTHER);
        }

        $form = $this->createForm(ReservaVueloType::class, $reservaVuelo);

        if ($this->isGranted('ROLE_TESORERO')) {
            $form->remove('duracion');
            $form->remove('avion');
            $formReserva = $form->get('reserva');
            $formReserva->remove('fecha_inicio');
            $formReserva->remove('fecha_fin');
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            if ($reservaVuelo->getReserva()->isAprobado()) {

                /** @var \DateTimeInterface $fechaInicio */
                $fechaInicio = $reservaVuelo->getReserva()->getFechaInicio();
                $fechaFin = $reservaVuelo->getReserva()->getFechaFin();

                // Validar que no se crucen con otras reservas aprobadas
                $conflictoVuelos = null;
                try {
                    $conflictoVuelos = $reservaVueloRepository->createQueryBuilder('rv')
                        ->join('rv.reserva', 'r')
                        ->where('r.aprobado = true')
                        ->andWhere('rv.avion = :avion')
                        ->andWhere('r.fecha_inicio BETWEEN :fecha_inicio AND :fecha_fin OR r.fecha_fin BETWEEN :fecha_inicio AND :fecha_fin OR r.fecha_inicio < :fecha_inicio AND r.fecha_fin > :fecha_fin')
                        ->setParameter('fecha_inicio', $fechaInicio->format('Y-m-d H:i:s'))
                        ->setParameter('fecha_fin', $fechaFin->format('Y-m-d H:i:s'))
                        ->setParameter('avion', $reservaVuelo->getAvion())
                        ->getQuery()
                        ->getSingleResult();
                } catch (NoResultException $e) {
                    $reservaVueloRepository->save($reservaVuelo, true);
                    return $this->redirectToRoute('app_reserva_vuelo_index', [], Response::HTTP_SEE_OTHER);

                } catch (NonUniqueResultException $e) {
                }

                $messageFlash = sprintf('El avion %s ya se encuentra con una reserva aprobada entre las %s y %s', $conflictoVuelos->getAvion()->getMatricula(),
                    $conflictoVuelos->getReserva()->getFechaInicio()->format('Y-m-d H:i:s'), $conflictoVuelos->getReserva()->getFechaFin()->format('Y-m-d H:i:s'));

                $this->addFlash(
                    'error',
                    $messageFlash
                );

            } else {
                $reservaVueloRepository->save($reservaVuelo, true);
                return $this->redirectToRoute('app_reserva_vuelo_index', [], Response::HTTP_SEE_OTHER);
            }

        }

        return $this->render('reserva_vuelo/edit.html.twig', [
            'reserva_vuelo' => $reservaVuelo,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reserva_vuelo_delete', methods: ['POST'])]
    public function delete(Request $request, ReservaVuelo $reservaVuelo, ReservaVueloRepository $reservaVueloRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $reservaVuelo->getId(), $request->request->get('_token'))) {
            $reservaVueloRepository->remove($reservaVuelo, true);
        }

        return $this->redirectToRoute('app_reserva_vuelo_index', [], Response::HTTP_SEE_OTHER);
    }
}
