<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/trick')]
class TrickController extends AbstractController
{
    #[Route('/', name: 'trick_index', methods: ['GET'])]
    public function index(TrickRepository $trickRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('trick/index.html.twig', [
            'tricks' => $trickRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'trick_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // getting images and videos transmitted by form
            $images = $form->get('images')->getData();
            $videos = $form->get('videos')->getData();
            $author = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

            // loop each images
            foreach ($images as $image) {
                // on récupère le nom original du fichier
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $image;
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on génère un nouveau nom de fichier à partir de l'original et en lui donnant un id unique
                $file = str_replace(' ', '-', $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension());

                //on copie le fichier dans le dossier upload
                $image->move(
                    $this->getParameter('trick_image_directory'),
                    $file
                );

                // On stock l'image dans la base de données (son nom)
                $img = new Image();
                $img->setTitle($file);
                $img->setCaption('Image of the '.$trick->getName().' trick');
                $img->setPath('build/images/tricks');

                $trick->addImage($img);
            }

            //loop each videos
            foreach ($videos as $url) {
                $video = new Video();

                $videoDatas = $this->formatVideoDatasFromUrl($url);
                if ($videoDatas) {
                    $video->setUrl($videoDatas['url']);
                    $video->setThumbnail($videoDatas['thumbnail']);

                    $trick->addVideo($video);
                }
            }

            $trick->setAuthor($author);
            $entityManager->persist($trick);
            $entityManager->flush();

            return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'trick_show')]
    public function show(Request $request, TrickRepository $trickRepository, string $slug): Response
    {
        $trick = $trickRepository->findOneBySlug($slug);
        $limit = $request->query->getInt('limit');

        return $this->render('trick/show.html.twig', [
            'trick' => $trick,
            'limit' => $limit + 4,
        ]);
    }

    #[Route('/{id}/edit', name: 'trick_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // on récupère les images transmises
            $images = $form->get('images')->getData();

            // on boucle sur les images
            foreach ($images as $image) {
                // on récupère le nom original du fichier
                /** @var UploadedFile $uploadedFile */
                $uploadedFile = $image;
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                // on génère un nouveau nom de fichier à partir de l'original et en lui donnant un id unique
                $file = str_replace(' ', '-', $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension());

                //on copie le fichier dans le dossier upload
                $image->move(
                    $this->getParameter('trick_image_directory'),
                    $file
                );

                // On stock l'image dans la base de données (son nom)
                $img = new Image();
                $img->setTitle($file);
                $img->setCaption('Image of the '.$trick->getName().' trick');
                $img->setPath('build/images/tricks');

                $trick->addImage($img);
            }

            $trick->setAuthor($this->getUser());
            $entityManager->persist($trick);

            $entityManager->flush();

            return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trick);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trick_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/delete/image/{id}', name: 'trick_delete_image', methods: 'DELETE')]
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $data = json_decode($request->getContent(), true);

        // check if token is valid
        if ($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])) {
            // Delete file
            unlink($this->getParameter('trick_image_directory').'/'.$image->getTitle());

            // Delete image in database
            $entityManager->remove($image);
            $entityManager->flush();

            // Json response
            return new JsonResponse(['success' => 1]);
        }

        return new JsonResponse(['error' => 'Invalid token'], 400);
    }

    public function formatVideoDatasFromUrl(string $url): array|false
    {
        $videoDatas = [];
        $isYoutube = str_contains($url, 'youtube');
        $isDailymotion = str_contains($url, 'dailymotion');

        if ($isYoutube | $isDailymotion) {
            if ($isYoutube) {
                $videoDatas['url'] = str_replace('watch?v=', 'embed/', $url);
                $separatedLinkElements = explode('/', $videoDatas['url']);
                $videoDatas['thumbnail'] = 'https://img.youtube.com/vi/'.end($separatedLinkElements).'/0.jpg';
            }
            if ($isDailymotion) {
                $videoDatas['url'] = str_replace('video', 'embed/video', $url);
                $separatedLinkElements = explode('/', $videoDatas['url']);
                $videoDatas['thumbnail'] = 'https://www.dailymotion.com/thumbnail/video/'.end($separatedLinkElements);
            }

            return $videoDatas;
        }

        return false;
    }
}
