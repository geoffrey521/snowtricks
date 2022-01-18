<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrickController extends AbstractController
{
    #[Route('/trick/{slug}', name: 'trick')]
    public function index(Request $request, TrickRepository $trickRepository, $slug): Response
    {
        $limit = $request->query->getInt('limit');
        $trick = $trickRepository->findOneBySlug($slug);

        return $this->render('trick/details.html.twig', [
            'trick' => $trick,
            'limit' => $limit + 4
        ]);
    }
}
