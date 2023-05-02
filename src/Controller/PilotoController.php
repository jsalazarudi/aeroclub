<?php

namespace App\Controller;

use App\Entity\Piloto;
use App\Entity\Usuario;
use App\Form\PilotoType;
use App\Repository\PilotoRepository;
use App\Repository\UsuarioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/piloto')]
class PilotoController extends AbstractController
{
    #[Route('/', name: 'aeroclub_piloto_index', methods: ['GET'])]
    public function index(Request $request, UsuarioRepository $usuarioRepository, PaginatorInterface $paginator): Response
    {
        $pilotosActivos = $usuarioRepository->createQueryBuilder('u')
            ->join('u.piloto','p')
            ->where('u.activo = true');

        $query = $pilotosActivos->getQuery();

        $pilotos = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            2
        );

        return $this->render('piloto/index.html.twig', [
            'usuarios' => $pilotos,
            'tipo' => 'Pilotos',
            'url_ruta_crear' => $this->generateUrl('aeroclub_piloto_new'),
            'url_ruta_listar' => $this->generateUrl('aeroclub_piloto_index')
        ]);
    }

    #[Route('/new', name: 'aeroclub_piloto_new', methods: ['GET', 'POST'])]
    public function new(Request $request, PilotoRepository $pilotoRepository): Response
    {
        $piloto = new Piloto();
        $piloto->setUsuario(new Usuario());

        $form = $this->createForm(PilotoType::class, $piloto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $piloto->getUsuario()->setRoles(['ROLE_PILOTO']);
            $piloto->getUsuario()->setActivo(true);

            $pilotoRepository->save($piloto, true);

            return $this->redirectToRoute('aeroclub_piloto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('piloto/new.html.twig', [
            'piloto' => $piloto,
            'form' => $form,
            'tipo' => 'Piloto',
            'url_ruta_listar' => $this->generateUrl('aeroclub_piloto_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_piloto_show', methods: ['GET'])]
    public function show(Piloto $piloto): Response
    {
        return $this->render('piloto/show.html.twig', [
            'piloto' => $piloto,
        ]);
    }

    #[Route('/{id}/edit', name: 'aeroclub_piloto_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Piloto $piloto, PilotoRepository $pilotoRepository): Response
    {
        $form = $this->createForm(PilotoType::class, $piloto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $pilotoRepository->save($piloto, true);

            return $this->redirectToRoute('aeroclub_piloto_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('piloto/edit.html.twig', [
            'piloto' => $piloto,
            'form' => $form,
            'tipo' => 'Piloto',
            'url_ruta_listar' => $this->generateUrl('aeroclub_piloto_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_piloto_delete', methods: ['POST'])]
    public function delete(Request $request, Piloto $piloto, PilotoRepository $pilotoRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $piloto->getId(), $request->request->get('_token'))) {
            $piloto->getUsuario()->setActivo(false);
            $pilotoRepository->save($piloto, true);
        }

        return $this->redirectToRoute('aeroclub_piloto_index', [], Response::HTTP_SEE_OTHER);
    }
}
