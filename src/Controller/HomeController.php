<?php

namespace App\Controller;

use App\Entity\Tesorero;
use App\Repository\NotaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'aeroclub_home')]
    public function index(NotaRepository $notaRepository): Response
    {
        $recordatorios = null;
        /** @var Tesorero|null $tesorero */
        $tesorero = $this->getUser()->getTesorero();
        if ($tesorero) {
            $recordatorios = $notaRepository->notasPorTesorero($tesorero);
        }

        return $this->render('home/index.html.twig',[
            'recordatorios' => $recordatorios
        ]);
    }
}
