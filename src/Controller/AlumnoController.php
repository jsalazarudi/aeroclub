<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Entity\HistorialListaPrecio;
use App\Entity\Usuario;
use App\Form\AlumnoType;
use App\Repository\AlumnoRepository;
use App\Repository\HistorialListaPrecioRepository;
use App\Repository\ListaPrecioRepository;
use App\Repository\UsuarioRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/alumno')]
class AlumnoController extends AbstractController
{
    #[Route('/', name: 'aeroclub_alumno_index', methods: ['GET'])]
    public function index(Request $request, UsuarioRepository $usuarioRepository, PaginatorInterface $paginator): Response
    {
        $alumnosActivos = $usuarioRepository->createQueryBuilder('u')
            ->join('u.alumno', 'a');

        $query = $alumnosActivos->getQuery();

        $alumnos = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('alumno/index.html.twig', [
            'usuarios' => $alumnos,
            'tipo' => 'Alumnos',
            'url_ruta_crear' => $this->generateUrl('aeroclub_alumno_new'),
            'url_ruta_listar' => $this->generateUrl('aeroclub_alumno_index')
        ]);
    }

    #[Route('/new', name: 'aeroclub_alumno_new', methods: ['GET', 'POST'])]
    public function new(Request $request, AlumnoRepository $alumnoRepository): Response
    {
        $alumno = new Alumno();
        $alumno->setUsuario(new Usuario());

        $form = $this->createForm(AlumnoType::class, $alumno);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $alumno->getUsuario()->setRoles(['ROLE_ALUMNO']);

            if ($alumno->isHabilitadoVolar()) {
                $alumno->setAprobado($this->getUser());
            }

            $alumnoRepository->save($alumno, true);

            return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alumno/new.html.twig', [
            'alumno' => $alumno,
            'form' => $form,
            'tipo' => 'Alumno',
            'url_ruta_listar' => $this->generateUrl('aeroclub_alumno_index')
        ]);
    }

    #[Route('/listado', name: 'aeroclub_alumno_listado_precios', methods: ['GET', 'POST'])]
    public function listado(Request $request, HistorialListaPrecioRepository $historialListaPrecioRepository, ListaPrecioRepository $listaPrecioRepository, PaginatorInterface $paginator): Response
    {
        $ultimaFechaHistorialListaPreciosQuery = $historialListaPrecioRepository->createQueryBuilder('hlp')
            ->select('MAX(hlp.fecha) AS fecha')
            ->getQuery();

        try {
            /** @var string $ultimaFechaHistorialListaPrecios */
            $ultimaFechaHistorialListaPrecios = $ultimaFechaHistorialListaPreciosQuery->getSingleScalarResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            $this->addFlash('error', 'No se encontraron historial de lista de precio o esta duplicado');
            return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        $ultimaFechaHistorialListaPreciosQuery = $historialListaPrecioRepository->createQueryBuilder('hlp')
            ->select('hlp')
            ->join('hlp.listaPrecios', 'lp')
            ->where('hlp.fecha = :fecha')
            ->setParameter('fecha', $ultimaFechaHistorialListaPrecios)
            ->getQuery();

        try {
            /** @var HistorialListaPrecio $ultimaHistorialListaPrecios */
            $ultimaHistorialListaPrecios = $ultimaFechaHistorialListaPreciosQuery->getSingleResult();
        } catch (NoResultException|NonUniqueResultException $e) {
            $this->addFlash('error', 'No se encontraron listas de precios relacionados al historial de lista de precio');
            return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        $listaPreciosQuery = $listaPrecioRepository->createQueryBuilder('lp')
            ->where('lp.historial_lista_precio = :historia_lista_precio')
            ->andWhere('lp.alumno = true')
            ->setParameter('historia_lista_precio', $ultimaHistorialListaPrecios)
            ->getQuery();

        $listaPrecios = $paginator->paginate(
            $listaPreciosQuery,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('alumno/listado.html.twig', [
            'lista_precios' => $listaPrecios
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
            $alumno->setAprobado($this->getUser());
            $alumnoRepository->save($alumno, true);

            return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('alumno/edit.html.twig', [
            'alumno' => $alumno,
            'form' => $form,
            'tipo' => 'Alumno',
            'url_ruta_listar' => $this->generateUrl('aeroclub_alumno_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_alumno_delete', methods: ['POST'])]
    public function delete(Request $request, Alumno $alumno, AlumnoRepository $alumnoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $alumno->getId(), $request->request->get('_token'))) {
            $alumnoRepository->remove($alumno, true);
        }

        return $this->redirectToRoute('aeroclub_alumno_index', [], Response::HTTP_SEE_OTHER);
    }

}
