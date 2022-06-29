<?php

namespace App\Notification;

use Twig\Environment;
use App\Entity\Contact;
use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;

class ContactNotification {

    public function notify(Contact $contact, MailerInterface $mailer, Environment $renderer) {
        
        $message = (new Email())
            ->from($contact->getEmail())
            ->to('minou@gmail.com')
            ->subject("Vous avez un message provenant de ".$contact->getFirstname())
            ->html($contact->getMessage());
        $mailer->send($message);
    }
}