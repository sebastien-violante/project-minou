<?php

namespace App\Controller;

use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    #[Route('cat/delete/{id}', name: 'deletecat')]
    public function index(
        CatRepository $catRepository,
        EntityManagerInterface $em,
        int $id
    ): Response
    {
        $em->remove($catRepository->findOneById($id));
        $em->flush();
        return $this->redirectToRoute('home');
    }
}
