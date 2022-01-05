<?php

namespace App\Controller;

use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(TrickRepository $repository): Response
    {
        $tricks = $repository->findBy([], ['createdAt' => 'DESC'], 15, 0);

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks
        ]);
    }
}
