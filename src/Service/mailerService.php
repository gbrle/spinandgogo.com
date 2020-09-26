<?php

namespace App\Service;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class mailerService
{

    private $mailer;

    public function __construct(MailerInterface $mailer)
    {
        $this->mailer = $mailer;
    }

    public function sendTokenConfirmationInscription($to, $subject, $contentMail, $template)
    {
        $email = (new TemplatedEmail())
            ->from("david@dg-web.fr")
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context(['contentMail' => $contentMail]);

        $this->mailer->send($email);
    }

    public function sendForgottenPasswordLink($to, $subject, $contentMail, $template, $user)
    {
        $email = (new TemplatedEmail())
            ->from("david@dg-web.fr")
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($template)
            ->context(['contentMail' => $contentMail, 'userName' => $user]);

        $this->mailer->send($email);
    }
}