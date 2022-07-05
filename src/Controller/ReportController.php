<?php

namespace App\Controller;

use Exception;
use App\Entity\Report;
use App\Form\ReportType;
use App\Service\Apiservice;
use App\Repository\CatRepository;
use Symfony\Component\Mime\Email;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Date;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    #[Route('/report/{cat_id}', name: 'report')]
    public function report(
        int $cat_id,
        CatRepository $catRepository,
        Request $request,
        ManagerRegistry $doctrine,
        MailerInterface $mailer,
    ): Response {
        $cat = $catRepository->findOneById($cat_id);
        $email = $cat->getEmail();
        $report = new Report;
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
                $em= $doctrine->getManager();
                $report->setDate(new \DateTime);
                $report->setCat($cat);
                $report->setStrored(false);
                $em->persist($report);
                $em->flush();
                return $this->redirectToRoute('home');
        }
        if ($cat->getEmail()) {
            $reportemail = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($cat->getEmail())
                ->subject('Alerte signalement !')
                ->html('<p>Bonjour, votre chat <b>'.$cat->getName().'</b> vient d etre repéré ! Connectez-vous à Minou et rendez-vous dans votre dashboard pour découvrir à quel endroit</p>');
            $mailer->send($reportemail);
        }
        $this->addFlash('success', "votre signalement a bien été pris en compte. Le propriétaire du chat vient de recevoir un email");
        return $this->render('report/index.html.twig', [
            'form' => $form->createView(),
            'cat' => $cat,
        ]);
    }
}
