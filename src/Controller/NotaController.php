<?php

namespace App\Controller;

use App\Entity\Nota;
use App\Entity\Tesorero;
use App\Form\NotaType;
use App\Repository\NotaRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/nota')]
class NotaController extends AbstractController
{
    #[Route('/', name: 'app_nota_index', methods: ['GET'])]
    public function index(Request $request,NotaRepository $notaRepository, PaginatorInterface $paginator): Response
    {
        $notasQuery = $notaRepository->createQueryBuilder('n');

        $query = $notasQuery->getQuery();

        $notas = $paginator->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );

        return $this->render('nota/index.html.twig', [
            'notas' => $notas,
        ]);
    }

    #[Route('/new', name: 'app_nota_new', methods: ['GET', 'POST'])]
    public function new(Request $request, NotaRepository $notaRepository): Response
    {
        $nota = new Nota();
        $form = $this->createForm(NotaType::class, $nota);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Tesorero|null $currentUser */
            $tesorero = $this->getUser()->getTesorero();
            if ($tesorero) {
                $nota->setTesorero($tesorero);
            }
            else {
                throw new \Exception('El usuario no es tesorero');
            }

            $notaRepository->save($nota, true);

            return $this->redirectToRoute('app_nota_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nota/new.html.twig', [
            'nota' => $nota,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nota_show', methods: ['GET'])]
    public function show(Nota $notum): Response
    {
        return $this->render('nota/show.html.twig', [
            'notum' => $notum,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_nota_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Nota $notum, NotaRepository $notaRepository): Response
    {
        $form = $this->createForm(NotaType::class, $notum);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $notaRepository->save($notum, true);

            return $this->redirectToRoute('app_nota_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('nota/edit.html.twig', [
            'notum' => $notum,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_nota_delete', methods: ['POST'])]
    public function delete(Request $request, Nota $notum, NotaRepository $notaRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$notum->getId(), $request->request->get('_token'))) {
            $notaRepository->remove($notum, true);
        }

        return $this->redirectToRoute('app_nota_index', [], Response::HTTP_SEE_OTHER);
    }
}
