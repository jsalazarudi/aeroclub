<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\VueloMotor;
use App\Form\VueloMotorType;
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
        /** @var Alumno $alumno */
        $alumno = $this->getUser()->getAlumno();

        $vuelosMotorQuery = $vueloMotorRepository->createQueryBuilder('vm')
            ->join('vm.vuelo', 'v')
            ->join('v.curso', 'c')
            ->where('c.alumno = :alumno')
            ->setParameter('alumno', $alumno);

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
    public function new(Request $request, VueloMotorRepository $vueloMotorRepository): Response
    {
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

        $vueloMotor = new VueloMotor();
        $form = $this->createForm(VueloMotorType::class, $vueloMotor, [
            'alumno' => $this->getUser()->getAlumno()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $vueloMotorRepository->save($vueloMotor, true);

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
    public function edit(Request $request, VueloMotor $vueloMotor, VueloMotorRepository $vueloMotorRepository): Response
    {
        $form = $this->createForm(VueloMotorType::class, $vueloMotor, [
            'alumno' => $this->getUser()->getAlumno()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $vueloMotorRepository->save($vueloMotor, true);

            return $this->redirectToRoute('app_vuelo_motor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('vuelo_motor/edit.html.twig', [
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
