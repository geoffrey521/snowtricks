<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/user')]
class UserController extends AbstractController
{
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function dashboard(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        /** @var User $usr */
        $usr = $user;

        $form = $this->createForm(AccountType::class, $usr);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $image = $form->get('avatarUrl')->getData();
            /** @var UploadedFile $uploadedFile */
            $uploadedFile = $image;
            if ($uploadedFile) {
                $originalFilename = pathinfo($uploadedFile->getClientOriginalName(), PATHINFO_FILENAME);
                $file = str_replace(' ', '-', $originalFilename.'-'.uniqid().'.'.$uploadedFile->guessExtension());
                $image->move(
                    $this->getParameter('user_image_directory'),
                    $file
                );
                $usr->setAvatarUrl($file);
                $usr->setAvatarPath('images/user');
                $entityManager->persist($usr);
                $entityManager->flush();
            }

            $this->addFlash(
                'success',
                'Your profile informations has been successfully changed'
            );
        }

        return $this->renderForm('user/dashboard.html.twig', [
            'form' => $form,
        ]);
    }
}
