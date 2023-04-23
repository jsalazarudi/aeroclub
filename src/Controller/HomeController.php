<?php

namespace App\Controller;

use App\Entity\Tesorero;
use App\Repository\CursoRepository;
use App\Repository\NotaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'aeroclub_home')]
    public function index(NotaRepository $notaRepository, CursoRepository $cursoRepository): Response
    {
        $recordatorios = null;
        /** @var Tesorero|null $tesorero */
        $tesorero = $this->getUser()->getTesorero();
        if ($tesorero) {
            $recordatorios = $notaRepository->notasPorTesorero($tesorero);
        }

        $notificacionCurso = null;
        /** @var Alumno|null $alumno */
        $alumno = $this->getUser()->getAlumno();

        if ($alumno) {
            $notificacionCurso = $cursoRepository->createQueryBuilder('c')
                ->select('SUM(mcv.unidades_gastadas)')
                ->join('c.vuelos', 'v')
                ->join('v.movimientoCuentaVuelo', 'mcv')
                ->where('c.alumno = :alumno')
                ->andWhere('c.aprobado = false')
                ->setParameter('alumno', $alumno)
                ->getQuery()
                ->getSingleScalarResult();

        }

        return $this->render('home/index.html.twig', [
            'recordatorios' => $recordatorios,
            'notificacion_curso' => $notificacionCurso
        ]);
    }
}
