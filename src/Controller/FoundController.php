<?php

namespace App\Controller;

use App\Repository\CatRepository;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\FrameworkBundle\Controller\RedirectController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoundController extends AbstractController
{
    #[Route('/found/{id}', name: 'found')]
    public function index(
        CatRepository $catrepository,
        int $id
    ): Response
    {
        $cat = $catrepository->findOneById($id);
        $cat->setIslost(false);
        return $this->render('found/index.html.twig', [
            'cat' => $cat
        ]);
    }

    #[Route('/storereports/{id}', name: 'storereports')]
    public function storeReports(
        ReportRepository $reportRepository,
        EntityManagerInterface $em,
        CatRepository $catRepository,
        int $id
    ): Response
    {
        $catRepository->findOneById($id)->setIslost(false);
        $reports = $reportRepository->findBy(['cat' => $id]);
        foreach ($reports as $report) {
            $report->setStrored(true);
            $em->persist($report);
            $em->flush();
        }
        return $this->redirectToRoute("home");
    }

    #[Route('/deletereports/{id}', name: 'deletereports')]
    public function deleteReports(
        ReportRepository $reportRepository,
        EntityManagerInterface $em,
        CatRepository $catRepository,
        int $id
    ): Response
    {
        $catRepository->findOneById($id)->setIslost(false);
        $reports = $reportRepository->findBy(['cat' => $id]);
        foreach ($reports as $report) {
            $em->remove($report);
            $em->flush();
        }
        return $this->redirectToRoute("home");
    }
}
