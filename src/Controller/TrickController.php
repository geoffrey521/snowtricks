<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
use App\Service\FormatVideo;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
            'tricks' => $trickRepository->findBy([], ['createdAt' => 'DESC']),
        ]);
    }

    #[Route('/new', name: 'trick_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager, UserRepository $userRepository, FileUploader $fileUploader): Response
    {
        $trick = new Trick();

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // getting images and videos transmitted by form
            $images = $form->get('images')->getData();
            $author = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);

            // loop each images
            foreach ($images as $image) {
                /** @var UploadedFile $uploadedFile */
                $file = $image;

                if ($file) {
                    $uploadedFileName = $fileUploader->uploadImage($file);
                    // get datas into database
                    $img = new Image();
                    $img->setTitle($uploadedFileName);
                    $img->setCaption('Image of the '.$trick->getName().' trick');
                    $img->setPath('images/tricks');

                    $trick->addImage($img);
                }
            }

            $trick->setAuthor($author);

            $entityManager->persist($trick);
            $entityManager->flush();

            $this->addFlash('success', 'Trick has been created');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/new.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}', name: 'trick_show')]
    public function show(Request $request, TrickRepository $trickRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, string $slug): Response
    {
        $trick = $trickRepository->findOneBySlug($slug);
        $limit = $request->query->getInt('limit');

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        $comment = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $author = $userRepository->findOneBy(['email' => $this->getUser()->getUserIdentifier()]);
            $comment->setAuthor($author);
            $trick->addComment($comment);
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Your comment has been posted');
        }

        return $this->renderForm('trick/show.html.twig', [
            'trick' => $trick,
            'limit' => $limit + 4,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/edit', name: 'trick_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager, FileUploader $fileUploader, FormatVideo $formatVideo): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // we get uploaded images
            $imagesDatas = $form->get('images')->getData();

            foreach ($imagesDatas as $imageData) {
                /** @var UploadedFile $uploadedFile */
                $file = $imageData;

                if (!empty($file)) {
                    $uploadedFileName = $fileUploader->uploadImage($file);
                    // get datas into database
                    $image = new Image();
                    $image->setTitle($uploadedFileName);
                    $image->setCaption('Image of the '.$trick->getName().' trick');
                    $image->setPath('images/tricks');
                    $image->setTrick($trick);

                    $trick->addImage($image);
                }
            }
            $trick->setAuthor($this->getUser());

            $entityManager->persist($trick);

            $entityManager->flush();

            $this->addFlash('success', 'Trick has been updated');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/edit.html.twig', [
            'trick' => $trick,
            'form' => $form,
        ]);
    }

    #[Route('/delete/{slug}', name: 'trick_delete', methods: ['POST'])]
    public function delete(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        if ($this->isCsrfTokenValid('delete'.$trick->getId(), $request->request->get('_token'))) {
            $entityManager->remove($trick);
            $entityManager->flush();
            $this->addFlash('success', 'Trick has been removed');
        }

        return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/edit/image/{id}', name: 'trick_edit_image')]
    #[IsGranted('ROLE_USER')]
    public function editVideo(Video $video, Request $request, EntityManagerInterface $entityManager)
    {
        dd($video);
    }

    #[Route('/delete/image/{id}', name: 'trick_delete_image', methods: 'DELETE')]
    #[IsGranted('ROLE_USER')]
    public function deleteImage(Image $image, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
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

    #[Route('/delete/video/{id}', name: 'trick_delete_video', methods: 'DELETE')]
    #[IsGranted('ROLE_USER')]
    public function deleteVideo(Video $video, Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        // check if token is valid
        if ($this->isCsrfTokenValid('delete'.$video->getId(), $data['_token'])) {
            // Delete video in database
            $entityManager->remove($video);
            $entityManager->flush();

            // Json response
            return new JsonResponse(['success' => 1]);
        }

        return new JsonResponse(['error' => 'Invalid token'], 400);
    }
}
