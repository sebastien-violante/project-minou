<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
        public function index(ArticleRepository $articlesRepository): Response
    {
        return $this->render('home/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
        ]);
    }
}
