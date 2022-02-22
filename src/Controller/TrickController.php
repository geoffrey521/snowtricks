<?php

namespace App\Controller;

use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\Video;
use App\Form\CommentType;
use App\Form\TrickType;
use App\Repository\CommentRepository;
use App\Repository\TrickRepository;
use App\Repository\UserRepository;
use App\Service\FileUploader;
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
    public function __construct(private FileUploader $fileUploader)
    {
    }

    #[Route('/new', name: 'trick_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $trick = new Trick();
        $trick->setAuthor($this->getUser());

        $form = $this->createForm(TrickType::class, $trick);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleTrickImages($trick, $form->get('photos')->getData());
            $this->handleTrickLinks($trick, $form->get('links')->getData());
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
    public function show(Request $request, TrickRepository $trickRepository, UserRepository $userRepository, EntityManagerInterface $entityManager, string $slug, CommentRepository $commentRepository): Response
    {
        $trick = $trickRepository->findOneBySlug($slug);
        $limit = $request->query->getInt('limit');

        $comments = $commentRepository->findBy(['trick' => $trick], ['createdAt' => 'DESC']);

        $form = $this->createForm(CommentType::class);
        $form->handleRequest($request);
        $comment = $form->getData();

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setAuthor($this->getUser());
            $trick->addComment($comment);
            $entityManager->persist($comment);
            $entityManager->flush();

            $this->addFlash('success', 'Your comment has been posted');

            return $this->redirectToRoute('trick_show', ['slug' => $trick->getSlug()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('trick/show.html.twig', [
            'trick' => $trick,
            'comments' => $comments,
            'limit' => $limit + 10,
            'form' => $form,
        ]);
    }

    #[Route('/{slug}/edit', name: 'trick_edit', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function edit(Request $request, Trick $trick, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TrickType::class, $trick);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->handleTrickImages($trick, $form->get('photos')->getData());
            $this->handleTrickLinks($trick, $form->get('links')->getData());
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

    #[Route('/{id}/image/promote', name: 'trick_promote_image', methods: ['POST'])]
    #[IsGranted('ROLE_USER')]
   public function promote(Request $request, Image $image, EntityManagerInterface $em): JsonResponse
   {
       if ($this->isCsrfTokenValid('promote'.$image->getId(), $request->toArray()['_token'])) {
           $oldPromotedImage = $image->getTrick()->getPromotedImage();
           if ($oldPromotedImage) {
               $oldPromotedImage->setPromoted(false);
               $em->persist($oldPromotedImage);
           }
           $image->setPromoted(true);
           $em->persist($oldPromotedImage);
           $em->flush();

           return new JsonResponse([
               'success' => true,
           ]);
       }

       return new JsonResponse([
           'success' => false,
           'error' => 'invalid datas',
       ]);
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

    private function handleTrickImages($trick, $images)
    {
        foreach ($images as $imageData) {
            /** @var UploadedFile $uploadedFile */
            $file = $imageData;

            if (!empty($file)) {
                $uploadedFileName = $this->fileUploader->uploadImage($file);
                // get datas into database
                $image = new Image();
                $image->setTitle($uploadedFileName);
                $image->setCaption('Image of the '.$trick->getName().' trick');
                $image->setPath($uploadedFileName);
                $image->setTrick($trick);

                $trick->addImage($image);
            }
        }
    }

    private function handleTrickLinks($trick, $linksData)
    {
        foreach ($linksData as $url) {
            if (empty($url)) {
                continue;
            }

            $video = new Video();
            $video->setUrl($url);
            $trick->addVideo($video);
        }
    }
}
