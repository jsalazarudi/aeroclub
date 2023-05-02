<?php

namespace App\Controller;

use App\Entity\Tesorero;
use App\Entity\Usuario;
use App\Form\TesoreroType;
use App\Repository\TesoreroRepository;
use App\Repository\UsuarioRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/tesorero')]
class TesoreroController extends AbstractController
{
    #[Route('/', name: 'aeroclub_tesorero_index', methods: ['GET'])]
    public function index(Request $request,UsuarioRepository $usuarioRepository, PaginatorInterface $paginator): Response
    {
        $tesorerosActivos = $usuarioRepository->createQueryBuilder('u')
            ->join('u.tesorero','t')
            ->where('u.activo = true');

        $query = $tesorerosActivos->getQuery();

        $tesoreros = $paginator->paginate(
            $query,
            $request->query->getInt('page',1),
            2
        );

        return $this->render('tesorero/index.html.twig', [
            'usuarios' => $tesoreros,
            'tipo' => 'Tesorero',
            'url_ruta_crear' => $this->generateUrl('aeroclub_tesorero_new'),
            'url_ruta_listar' => $this->generateUrl('aeroclub_tesorero_index')
        ]);
    }

    #[Route('/new', name: 'aeroclub_tesorero_new', methods: ['GET', 'POST'])]
    public function new(Request $request, TesoreroRepository $tesoreroRepository, UserPasswordHasherInterface $passwordHasher): Response
    {
        $tesorero = new Tesorero();
        $tesorero->setUsuario(new Usuario());

        $form = $this->createForm(TesoreroType::class, $tesorero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tesorero->getUsuario()->setRoles(['ROLE_TESORERO']);
            $tesorero->getUsuario()->setActivo(true);

            $tesoreroRepository->save($tesorero, true);
            return $this->redirectToRoute('aeroclub_tesorero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tesorero/new.html.twig', [
            'tesorero' => $tesorero,
            'form' => $form,
            'tipo' => 'Tesorero',
            'url_ruta_listar' => $this->generateUrl('aeroclub_tesorero_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_tesorero_show', methods: ['GET'])]
    public function show(Tesorero $tesorero): Response
    {
        return $this->render('tesorero/show.html.twig', [
            'tesorero' => $tesorero,
        ]);
    }

    #[Route('/{id}/edit', name: 'aeroclub_tesorero_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Tesorero $tesorero, TesoreroRepository $tesoreroRepository): Response
    {
        $form = $this->createForm(TesoreroType::class, $tesorero);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $tesoreroRepository->save($tesorero, true);

            return $this->redirectToRoute('aeroclub_tesorero_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('tesorero/edit.html.twig', [
            'tesorero' => $tesorero,
            'form' => $form,
            'tipo' => 'Tesorero',
            'url_ruta_listar' => $this->generateUrl('aeroclub_tesorero_index')
        ]);
    }

    #[Route('/{id}', name: 'aeroclub_tesorero_delete', methods: ['POST'])]
    public function delete(Request $request, Tesorero $tesorero, TesoreroRepository $tesoreroRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$tesorero->getId(), $request->request->get('_token'))) {
            $tesoreroRepository->remove($tesorero,true);
        }

        return $this->redirectToRoute('aeroclub_tesorero_index', [], Response::HTTP_SEE_OTHER);
    }
}
