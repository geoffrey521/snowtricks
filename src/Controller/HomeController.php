<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\ImageRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
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
//        foreach ($tricks as $trick) {
//            dd($trick->getImages()[0]);
//        }

        return $this->render('home/index.html.twig', [
            'tricks' => $tricks,
            'limit' => $limit + 15
        ]);
    }

}
