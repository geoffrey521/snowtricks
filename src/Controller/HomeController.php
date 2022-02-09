<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(Request $request, TrickRepository $trickRepository): Response
    {
        $limit = $request->query->getInt('limit', 15);
        $tricks = $trickRepository->findBy([], ['createdAt' => 'DESC'], $limit);

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'limit' => $limit + 15,
        ]);
    }
}
