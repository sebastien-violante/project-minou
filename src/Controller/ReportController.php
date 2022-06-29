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
                $report->setDate(new Date);
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
                ->html('<img src="https://placekitten.com/300/400"  style="height: 60px, width: 100%, object-fit:cover" background: linear-gradient(rgba(to bottom rgb(0,0,0,0) 80%, rbga(0,0,0,1);><p>Bonjour, votre chat <b>'.$cat->getName().'</b> vient d etre repéré ! Connectez-vous à Minou et rendez-vous dans votre dashboard pour découvrir à quel endroit</p>');
            $mailer->send($reportemail);
        }

        return $this->render('report/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
