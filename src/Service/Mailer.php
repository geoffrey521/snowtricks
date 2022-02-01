<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    public function __construct(private MailerInterface $mailer)
    {}

    public function sendEmail($recipient, $token)
    {
        $email = (new TemplatedEmail())
            ->from('register@example.com')
            ->to(new Address($recipient))
            ->subject('Validate your account')

            // path of the Twig template to render
            ->htmlTemplate('emails/registration.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new \DateTime('+7 days'),
                'token' => $token,
            ])
        ;
        $this->mailer->send($email);
    }
}