<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Service\Mailer;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;

class RegistrationController extends AbstractController
{
    public function __construct(private UserPasswordHasherInterface $userPasswordHasher, private Mailer $mailer, private UserRepository $userRepository)
    {
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setAgreedTermsAt(new DateTimeImmutable());
            $user->setIsActive(false);
            $user->setConfirmToken($this->generateToken());

            // encode the plain password
            $user->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $this->mailer->sendEmail($user->getEmail(), $user->getConfirmToken());
            $this->addFlash('success', 'Account successfully created, please check your emails for activation');

            return $this->redirectToRoute('home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    /**
     * @throws \Exception
     *
     * @return string
     */
    public function generateToken(): string
    {
        $bytes = random_bytes(30);

        return bin2hex($bytes);
    }

    #[Route('/confirm_account/{token}', name: 'confirm_account')]
    public function confirmAccount($token, EntityManagerInterface $entityManager): Response
    {
        $user = $this->userRepository->findOneBy(['confirmToken' => $token]);

        if ($user) {
            $user->setConfirmToken(null);
            $user->setIsActive(true);
            $user->setVerifiedAt(new DateTime('now'));

            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Your account is successfully activated');

            return $this->redirectToRoute('home');
        }

        $this->addFlash('error', 'The followed link is invalid');

        return $this->redirectToRoute('home');
    }
}
