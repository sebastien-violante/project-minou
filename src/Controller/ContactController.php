<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Twig\Environment;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'contact')]
    public function contact(
        Request $request,
        ContactNotification $notification,
        MailerInterface $mailer,
        Environment $renderer,
    ): Response
    {
        $contact = new Contact;
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $notification->notify($contact, $mailer, $renderer);
            $this->addFlash('success', "votre message a bien été envoyé à l'administrateur du site");
            return $this->redirectToRoute('home');
        }
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
