<?php

namespace App\Controller;

use App\Repository\CatRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CatListController extends AbstractController
{
    #[Route('/cat/list', name: 'cat-list')]
    public function index(
        CatRepository $catRepository
    ): Response
    {
        $email = $this->getUser()->getEmail();
        return $this->render('cat_list/index.html.twig', [
            'cats' => $catRepository->findByEmail($email),
        ]);
    }
}
