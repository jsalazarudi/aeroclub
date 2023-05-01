<?php

namespace App\Controller;

use App\Entity\HistorialListaPrecio;
use App\Entity\ListaPrecio;
use App\Form\ListaPrecioType;
use App\Repository\HistorialListaPrecioRepository;
use App\Repository\ListaPrecioRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/lista/precio')]
class ListaPrecioController extends AbstractController
{
    #[Route('/', name: 'app_lista_precio_index', methods: ['GET'])]
    public function index(Request $request, ListaPrecioRepository $listaPrecioRepository, PaginatorInterface $paginator): Response
    {
        $listaPreciosQuery = $listaPrecioRepository->createQueryBuilder('l');

        $query = $listaPreciosQuery->getQuery();

        $listaPrecios = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('lista_precio/index.html.twig', [
            'lista_precios' => $listaPrecios,
        ]);
    }

    #[Route('/new', name: 'app_lista_precio_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ListaPrecioRepository $listaPrecioRepository, HistorialListaPrecioRepository $historialListaPrecioRepository): Response
    {
        $listaPrecio = new ListaPrecio();
        $form = $this->createForm(ListaPrecioType::class, $listaPrecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            /** @var string $ultimaFechaHistorialListaPrecios */
            $ultimaFechaHistorialListaPrecios = $historialListaPrecioRepository->createQueryBuilder('hlp')
                ->select('MAX(hlp.fecha) AS fecha')
                ->getQuery()
                ->getSingleScalarResult();


            /** @var HistorialListaPrecio $ultimaHistorialListaPrecios */
            $ultimaHistorialListaPrecios = $historialListaPrecioRepository->createQueryBuilder('hlp')
                ->where('hlp.fecha = :fecha')
                ->setParameter('fecha', $ultimaFechaHistorialListaPrecios)
                ->getQuery()
                ->getSingleResult();

            $checkboxValues = [$listaPrecio->isBautismo(),$listaPrecio->isAlumno(),$listaPrecio->isSocio()];
            $filteredValues = array_filter($checkboxValues,function ($checkbox){
                return $checkbox;
            });

            if (!$listaPrecio->getServicio() && !$listaPrecio->getProducto() && !$listaPrecio->getAvion()) {
                $this->addFlash('error','Debe seleccionar al menos una opcion de Servicio,Avion o Producto');

                return $this->render('lista_precio/new.html.twig', [
                    'lista_precio' => $listaPrecio,
                    'form' => $form,
                ]);
            }

            // VALIDACIONES AVION
            if ($listaPrecio->getAvion()) {

                // VALIDAR QUE NO ESTE SETIADO PRODUCTO O SERVICIO. SOLO PUEDE ESTAR SETIADO AVION
                if ($listaPrecio->getProducto() || $listaPrecio->getServicio()) {
                    $this->addFlash('error','Solo puede seleccionar una opcion entre producto, servicio y avion');

                    return $this->render('lista_precio/new.html.twig', [
                        'lista_precio' => $listaPrecio,
                        'form' => $form,
                    ]);
                }

                // VALIDAR QUE SOLO ESTE SETIADO UNA OPCION ENTRE SOCIO,ALUMNO,BAUTISMO
                if (count($filteredValues) > 1) {
                    $this->addFlash('error','Solo puede seleccionar una opcion entre bautismo, alumno y socio');

                    return $this->render('lista_precio/new.html.twig', [
                        'lista_precio' => $listaPrecio,
                        'form' => $form,
                    ]);
                }

                // VALIDAR QUE NO SE DUPLIQUE UN PRECIO PARA UN AVION DE VUELO BAUTISMO,ALUMNO Y SOCIO
                $principalQuery = $listaPrecioRepository->createQueryBuilder('lp')
                    ->where('lp.avion = :avion')
                    ->setParameter('avion',$listaPrecio->getAvion())
                    ->andWhere('lp.historial_lista_precio = :historial_lista_precio')
                    ->setParameter('historial_lista_precio', $ultimaHistorialListaPrecios);


                if ($listaPrecio->isBautismo()) {
                    $principalQuery->andWhere('lp.bautismo = true');
                } elseif ($listaPrecio->isAlumno()) {
                    $principalQuery->andWhere('lp.alumno = true');
                } elseif ($listaPrecio->isSocio()) {
                    $principalQuery->andWhere('lp.socio = true');
                }

                try {
                    $resultQuery = $principalQuery->getQuery()->getSingleResult();
                } catch (NoResultException $e) {
                    $listaPrecioRepository->save($listaPrecio, true);
                    return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
                } catch (NonUniqueResultException $e) {
                    $this->addFlash('error','Existen dos listas de precio para el mismo avion');
                    return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
                }

                $this->addFlash('error','Ya existe un precio para este avion para ese rol');

                return $this->render('lista_precio/new.html.twig', [
                    'lista_precio' => $listaPrecio,
                    'form' => $form,
                ]);
            }

            // VALIDACION PRODUCTO
            if ($listaPrecio->getProducto()) {
                // VALIDAR QUE NO ESTE SETIADO AVION O SERVICIO. SOLO PUEDE ESTAR SETIADO PRODUCTO
                if ($listaPrecio->getServicio() || $listaPrecio->getAvion()) {
                    $this->addFlash('error','Solo puede seleccionar una opcion entre producto, servicio y avion');

                    return $this->render('lista_precio/new.html.twig', [
                        'lista_precio' => $listaPrecio,
                        'form' => $form,
                    ]);

                }

                if ($listaPrecio->isAlumno() || $listaPrecio->isBautismo()) {
                    $this->addFlash('error','Para poner precio a un producto solo esta disponible para los socios y no socios');

                    return $this->render('lista_precio/new.html.twig', [
                        'lista_precio' => $listaPrecio,
                        'form' => $form,
                    ]);
                }
            }

            // VALIDACION SERVICIO
            if ($listaPrecio->getServicio()) {
                // VALIDAR QUE NO ESTE SETIADO AVION O SERVICIO. SOLO PUEDE ESTAR SETIADO PRODUCTO
                if ($listaPrecio->getProducto() || $listaPrecio->getAvion()) {
                    $this->addFlash('error','Solo puede seleccionar una opcion entre producto, servicio y avion');

                    return $this->render('lista_precio/new.html.twig', [
                        'lista_precio' => $listaPrecio,
                        'form' => $form,
                    ]);
                }

                if ($listaPrecio->isBautismo() || $listaPrecio->isAlumno()) {
                    $this->addFlash('error','Solo se puede seleccionar socio si es necesario para el precio de los servicios');

                    return $this->render('lista_precio/new.html.twig', [
                        'lista_precio' => $listaPrecio,
                        'form' => $form,
                    ]);
                }



            }

            $listaPrecioRepository->save($listaPrecio, true);
            return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lista_precio/new.html.twig', [
            'lista_precio' => $listaPrecio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lista_precio_show', methods: ['GET'])]
    public function show(ListaPrecio $listaPrecio): Response
    {
        return $this->render('lista_precio/show.html.twig', [
            'lista_precio' => $listaPrecio,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_lista_precio_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ListaPrecio $listaPrecio, ListaPrecioRepository $listaPrecioRepository): Response
    {
        $form = $this->createForm(ListaPrecioType::class, $listaPrecio);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $listaPrecioRepository->save($listaPrecio, true);

            return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('lista_precio/edit.html.twig', [
            'lista_precio' => $listaPrecio,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_lista_precio_delete', methods: ['POST'])]
    public function delete(Request $request, ListaPrecio $listaPrecio, ListaPrecioRepository $listaPrecioRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $listaPrecio->getId(), $request->request->get('_token'))) {
            $listaPrecioRepository->remove($listaPrecio, true);
        }

        return $this->redirectToRoute('app_lista_precio_index', [], Response::HTTP_SEE_OTHER);
    }
}
