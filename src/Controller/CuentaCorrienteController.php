<?php

namespace App\Controller;

use App\Entity\Alumno;
use App\Repository\MovimientoCuentaVueloRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/cuenta/corriente')]
class CuentaCorrienteController extends AbstractController
{
    #[Route('/listado', name: 'app_cuenta_corriente_listado_index', methods: ['GET'])]
    public function listado(Request $request,MovimientoCuentaVueloRepository $movimientoCuentaVueloRepository,PaginatorInterface $paginator): Response
    {
        /** @var Alumno $alumno */
        $alumno = $this->getUser()->getAlumno();

        $cuentaCorrienteQuery = $movimientoCuentaVueloRepository->createQueryBuilder('mcv')
            ->join('mcv.vuelo','v')
            ->join('v.curso','c')
            ->andWhere('c.alumno = :alumno')
            ->setParameter('alumno',$alumno);

        $query = $cuentaCorrienteQuery->getQuery();

        $cuentaCorriente = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('cuenta_corriente/listado.html.twig', [
            'cuenta_corriente' => $cuentaCorriente
        ]);
    }
}
