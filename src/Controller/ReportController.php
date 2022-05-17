<?php

namespace App\Controller;

use App\Entity\Report;
use App\Form\ReportType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReportController extends AbstractController
{
    #[Route('/report', name: 'report')]
    public function report(
        Request $request,
        ManagerRegistry $doctrine,
    ): Response {
        $report = new Report;
        $form = $this->createForm(ReportType::class, $report);
        $form->handleRequest($request);
        $mail = $this->getUser()->getEmail();

        if ($form->isSubmitted() && $form->isValid()) {
            $em= $doctrine->getManager();
            $report->setDate(new DateTime);
            
            $em->persist($report);
            $em->flush();
            return $this->redirectToRoute('home');
        }

        return $this->render('report/index.html.twig', [
            'controller_name' => 'ReportController',
        ]);
    }
}