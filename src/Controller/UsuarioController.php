<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Form\AlumnoType;
use App\Form\InstructorType;
use App\Form\PilotoType;
use App\Form\SocioType;
use App\Form\TesoreroType;
use App\Form\UsuarioType;
use App\Model\Usuario;
use App\Repository\AlumnoRepository;
use App\Repository\InstructorRepository;
use App\Repository\PilotoRepository;
use App\Repository\SocioRepository;
use App\Repository\TesoreroRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/usuario')]
class UsuarioController extends AbstractController
{
    #[Route('/', name: 'aeroclub_usuario')]
    public function index(Request $request, AlumnoRepository $alumnoRepository, SocioRepository $socioRepository, InstructorRepository $instructorRepository,
                          PilotoRepository $pilotoRepository, TesoreroRepository $tesoreroRepository, PaginatorInterface $paginator, EntityManagerInterface $entityManager): Response
    {
        $allTesoreros = $tesoreroRepository->createQueryBuilder('t')->andWhere('t.activo = true');
        $query = $allTesoreros->getQuery();

        $pagination = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            2
        );


        $form = $this->createForm(UsuarioType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var Usuario $usuario */
            $usuario = $form->getData();
            $tipoUsuario = $usuario->getRole();

            if ($tipoUsuario == "Alumno") {
                return $this->redirectToRoute('aeroclub_alumno_new');
            }

            if ($tipoUsuario == "Socio") {
                return $this->redirectToRoute('aeroclub_socio_new');
            }

            if ($tipoUsuario == "Piloto") {
                return $this->redirectToRoute('aeroclub_piloto_new');
            }

            if ($tipoUsuario == "Instructor") {
                return $this->redirectToRoute('aeroclub_instructor_new');
            }

            if ($tipoUsuario == "Tesorero") {
                return $this->redirectToRoute('aeroclub_tesorero_new');
            }
        }

        return $this->render('usuario/index.html.twig', [
            'form' => $form,
            'tesoreros' => $pagination
        ]);
    }
}
