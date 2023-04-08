<?php

namespace App\Controller;

use App\Entity\Instructor;
use App\Entity\Usuario;
use App\Form\InstructorType;
use App\Repository\InstructorRepository;
use App\Repository\UsuarioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/instructor')]
class InstructorController extends AbstractController
{
    #[Route('/', name: 'aeroclub_instructor_index', methods: ['GET'])]
    public function index(Request $request, UsuarioRepository $usuarioRepository, PaginatorInterface $paginator): Response
    {
        $instructoresActivos = $usuarioRepository->createQueryBuilder('u')
            ->join('u.instructor','i')
            ->where('u.activo = true');

        $query = $instructoresActivos->getQuery();

        $instructores = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('instructor/index.html.twig', [
            'usuarios' => $instructores,
            'tipo' => 'Instructores',
            'url_ruta_crear' => $this->generateUrl('aeroclub_instructor_new'),
            'url_ruta_listar' => $this->generateUrl('aeroclub_instructor_index')
        ]);
    }

    #[Route('/new', name: 'aeroclub_instructor_new', methods: ['GET', 'POST'])]
    public function new(Request $request, InstructorRepository $instructorRepository): Response
    {
        $instructor = new Instructor();
        $instructor->setUsuario(new Usuario());

        $form = $this->createForm(InstructorType::class, $instructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instructor->getUsuario()->setRoles(['ROLE_INSTRUCTOR']);
            $instructor->getUsuario()->setActivo(true);

            $instructorRepository->save($instructor, true);

            return $this->redirectToRoute('aeroclub_instructor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instructor/new.html.twig', [
            'instructor' => $instructor,
            'form' => $form,
            'tipo' => 'Instructores',
            'url_ruta_listar' => $this->generateUrl('aeroclub_instructor_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_instructor_show', methods: ['GET'])]
    public function show(Instructor $instructor): Response
    {
        return $this->render('instructor/show.html.twig', [
            'instructor' => $instructor,
        ]);
    }

    #[Route('/{id}/edit', name: 'aeroclub_instructor_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Instructor $instructor, InstructorRepository $instructorRepository): Response
    {
        $form = $this->createForm(InstructorType::class, $instructor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $instructorRepository->save($instructor, true);

            return $this->redirectToRoute('aeroclub_instructor_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('instructor/edit.html.twig', [
            'instructor' => $instructor,
            'form' => $form,
            'tipo' => 'Alumnos',
            'url_ruta_listar' => $this->generateUrl('aeroclub_instructor_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_instructor_delete', methods: ['POST'])]
    public function delete(Request $request, Instructor $instructor, InstructorRepository $instructorRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $instructor->getId(), $request->request->get('_token'))) {
            $instructor->getUsuario()->setActivo(false);
            $instructorRepository->save($instructor, true);
        }

        return $this->redirectToRoute('aeroclub_instructor_index', [], Response::HTTP_SEE_OTHER);
    }
}
