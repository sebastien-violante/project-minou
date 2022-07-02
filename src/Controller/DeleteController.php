<?php

namespace App\Controller;

use App\Repository\CatRepository;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('cat/delete/{id}', name: 'deletecat')]
    public function index(
        CatRepository $catRepository,
        ReportRepository $reportRepository,
        EntityManagerInterface $em,
        int $id
    ): Response
    {
        $reportsId = $reportRepository->findBy(['cat' => $id]);
        foreach ($reportsId as $reportId) {
            $em->remove($reportRepository->findOneby(['id' => $reportId]));
        }
        $em->remove($catRepository->findOneById($id));
        $em->flush();
        return $this->redirectToRoute('home');
    }
}
