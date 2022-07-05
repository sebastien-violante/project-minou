<?php

namespace App\Controller;

use App\Repository\ReportRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ApiPostController extends AbstractController
{
    #[Route('/api/post/{id}', name: 'app_api_post_index', methods:['GET'])]
    public function index(ReportRepository $reportRepository, int $id): Response
    {
        return $this->json($reportRepository->findBy(['cat' => $id]), 200, [],['groups' => 'reports']);
    }
}
