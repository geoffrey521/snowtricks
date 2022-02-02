<?php

namespace App\Service;

use DateTime;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

class Mailer
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function sendEmail(string $template, string $recipient, string $subject, array $options = [], string $expired = '+7 days'): void
    {
        $email = (new TemplatedEmail())
            ->from('mailbot@example.com')
            ->to(new Address($recipient))
            ->subject($subject)

            // path of the Twig template to render
            ->htmlTemplate('emails/'.$template.'.html.twig')

            // pass variables (name => value) to the template
            ->context([
                'expiration_date' => new DateTime($expired),
                'options' => $options,
            ])
        ;
        $this->mailer->send($email);
    }
}
