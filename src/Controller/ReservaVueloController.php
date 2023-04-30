<?php

namespace App\Controller;

use App\Entity\ReservaVuelo;
use App\Entity\Socio;
use App\Entity\Tesorero;
use App\Entity\Usuario;
use App\Form\ReservaVueloType;
use App\Repository\ReservaVueloRepository;
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
        $reservasVueloQuery = null;
        $isTesorero = $this->isGranted('ROLE_TESORERO');

        if ($isTesorero) {
            $reservasVueloQuery = $reservaVueloRepository->createQueryBuilder('rv')
                ->join('rv.reserva', 'r');
        }

        $isSocioPiloto = $this->isGranted('ROLE_SOCIO') || $this->isGranted('ROLE_PILOTO');

        if ($isSocioPiloto && !$isTesorero) {
            $tipoUsuario = $this->getTipoUsuario();
            $reservasVueloQuery = $reservaVueloRepository->createQueryBuilder('rv')
                ->join('rv.reserva', 'r');

            if ($this->isGranted('ROLE_SOCIO')) {
                $reservasVueloQuery->where('r.socio = :socio')
                    ->setParameter('socio', $tipoUsuario);
            } elseif ($this->isGranted('ROLE_PILOTO')) {

                $reservasVueloQuery->where('r.piloto = :piloto')
                    ->setParameter('piloto', $tipoUsuario);
            }
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
            $tipoUsuario = $this->getTipoUsuario();

            if ($this->isGranted('ROLE_SOCIO')) {
                $reservaVuelo->getReserva()->setSocio($tipoUsuario);
            } elseif ($this->isGranted('ROLE_PILOTO')) {
                $reservaVuelo->getReserva()->setPiloto($tipoUsuario);
            }
            $reservaVueloRepository->save($reservaVuelo, true);

            return $this->redirectToRoute('app_reserva_vuelo_index', [], Response::HTTP_SEE_OTHER);
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
        $form = $this->createForm(ReservaVueloType::class, $reservaVuelo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $reservaVueloRepository->save($reservaVuelo, true);

            return $this->redirectToRoute('app_reserva_vuelo_index', [], Response::HTTP_SEE_OTHER);
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
