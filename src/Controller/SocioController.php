<?php

namespace App\Controller;

use App\Entity\PagoMensualidad;
use App\Entity\Socio;
use App\Entity\Usuario;
use App\Form\SocioType;
use App\Repository\PagoMensualidadRepository;
use App\Repository\SocioRepository;
use App\Repository\UsuarioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/socio')]
class SocioController extends AbstractController
{
    #[Route('/', name: 'aeroclub_socio_index', methods: ['GET'])]
    public function index(Request $request, UsuarioRepository $usuarioRepository, PaginatorInterface $paginator): Response
    {
        $sociosActivos = $usuarioRepository->createQueryBuilder('u')
            ->join('u.socio','s')
            ->where('u.activo = true');

        $query = $sociosActivos->getQuery();

        $socios = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('socio/index.html.twig', [
            'usuarios' => $socios,
            'tipo' => 'Socios',
            'url_ruta_crear' => $this->generateUrl('aeroclub_socio_new'),
            'url_ruta_listar' => $this->generateUrl('aeroclub_socio_index')
        ]);
    }

    #[Route('/new', name: 'aeroclub_socio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, SocioRepository $socioRepository, PagoMensualidadRepository $pagoMensualidadRepository): Response
    {
        $socio = new Socio();
        $socio->setUsuario(new Usuario());

        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $socio->getUsuario()->setRoles(['ROLE_SOCIO']);
            $socio->getUsuario()->setActivo(true);

            // ANTES DE GUARDAR, SETIAR LOS PAGOS PENDIENTES MENSUALES
            // EN BASE A LA FECHA INICIO Y FECHA FIN DE LA MENSUALIDAD
            foreach ($socio->getMensualidades() as $mensualidad) {
                $inicio = $mensualidad->getFechaInicio();
                $fin = $mensualidad->getFechaFin();
                $interval = new \DateInterval('P1M');
                $range = new \DatePeriod($inicio,$interval,$fin);

                foreach ($range as $date) {
                    $pagoMensualidad = new PagoMensualidad();
                    $pagoMensualidad->setFecha($date);
                    $pagoMensualidad->setMensualidad($mensualidad);
                    $pagoMensualidadRepository->save($pagoMensualidad);
                }
            }

            $socioRepository->save($socio, true);
            return $this->redirectToRoute('aeroclub_socio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('socio/new.html.twig', [
            'socio' => $socio,
            'form' => $form,
            'tipo' => 'Socios',
            'url_ruta_listar' => $this->generateUrl('aeroclub_socio_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_socio_show', methods: ['GET'])]
    public function show(Socio $socio): Response
    {
        return $this->render('socio/show.html.twig', [
            'socio' => $socio,
        ]);
    }

    #[Route('/{id}/edit', name: 'aeroclub_socio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Socio $socio, SocioRepository $socioRepository, PagoMensualidadRepository $pagoMensualidadRepository): Response
    {
        $form = $this->createForm(SocioType::class, $socio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            // ANTES DE GUARDAR, SETIAR LOS PAGOS PENDIENTES MENSUALES
            // EN BASE A LA FECHA INICIO Y FECHA FIN DE LA MENSUALIDAD
            foreach ($socio->getMensualidades() as $mensualidad) {
                if (!$mensualidad->getId()) {
                    $inicio = $mensualidad->getFechaInicio();
                    $fin = $mensualidad->getFechaFin();
                    $interval = new \DateInterval('P1M');
                    $range = new \DatePeriod($inicio,$interval,$fin);

                    foreach ($range as $date) {
                        $pagoMensualidad = new PagoMensualidad();
                        $pagoMensualidad->setFecha($date);
                        $pagoMensualidad->setMensualidad($mensualidad);
                        $pagoMensualidadRepository->save($pagoMensualidad);
                    }
                }
            }

            $socioRepository->save($socio, true);

            return $this->redirectToRoute('aeroclub_socio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('socio/edit.html.twig', [
            'socio' => $socio,
            'form' => $form,
            'tipo' => 'Socios',
            'url_ruta_listar' => $this->generateUrl('aeroclub_socio_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_socio_delete', methods: ['POST'])]
    public function delete(Request $request, Socio $socio, SocioRepository $socioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $socio->getId(), $request->request->get('_token'))) {
            $socio->getUsuario()->setActivo(false);
            $socioRepository->save($socio, true);
        }

        return $this->redirectToRoute('aeroclub_socio_index', [], Response::HTTP_SEE_OTHER);
    }
}
