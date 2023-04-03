<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\Instructor;
use App\Entity\Tesorero;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

#[Route('/alumno')]
class AlumnoController extends AbstractController
{
    #[Route('/', name: 'aeroclub_alumno_index', methods: ['GET'])]
    public function index(Request $request,AlumnoRepository $alumnoRepository,PaginatorInterface $paginator): Response
    {
        // dd($this->getUser());
        $alumnosActivos = $alumnoRepository->createQueryBuilder('a')->andWhere('a.activo = true');
        $query = $alumnosActivos->getQuery();

        $alumnos = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            2
        );

        return $this->render('alumno/index.html.twig', [
            'alumnos' => $alumnos,
        ]);
    }

    #[Route('/new', name: 'aeroclub_alumno_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AlumnoRepository $alumnoRepository): Response
    {
        $alumno = new Alumno();
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $alumno->setActivo(true);
            $this->validarHabilitadoParaVolar($alumno);
            $alumnoRepository->save($alumno, true);

            return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alumno/new.html.twig', [
            'alumno' => $alumno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_alumno_show', methods: ['GET'])]
    public function show(Alumno $alumno): Response
    {
        return $this->render('alumno/show.html.twig', [
            'alumno' => $alumno,
        ]);
    }

    #[Route('/{id}/edit', name: 'aeroclub_alumno_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Alumno $alumno, AlumnoRepository $alumnoRepository): Response
    {
        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->validarHabilitadoParaVolar($alumno);
            $alumnoRepository->save($alumno, true);

            return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alumno/edit.html.twig', [
            'alumno' => $alumno,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_alumno_delete', methods: ['POST'])]
    public function delete(Request $request, Alumno $alumno, AlumnoRepository $alumnoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$alumno->getId(), $request->request->get('_token'))) {
            $alumno->setActivo(false);
            $alumnoRepository->save($alumno, true);
        }

        return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @param Alumno $alumno
     * @return void
     */
    private function validarHabilitadoParaVolar(Alumno $alumno)
    {
        if ($alumno->isHabilitadoVolar()) {
            /** @var UserInterface|Tesorero|Instructor $currentUser */
            $currentUser = $this->getUser();
            if (get_class($currentUser) === 'App\Entity\Tesorero' && is_null($alumno->getHabilitadoPorTesoreroId())) {
                $alumno->setHabilitadoPorTesoreroId($currentUser);
            } elseif (get_class($currentUser) === 'App\Entity\Instructor' && is_null($alumno->getHabilitadoPorInstructorId())) {
                $alumno->setHabilitadoPorInstructorId($currentUser);
            }
        }
    }
}
