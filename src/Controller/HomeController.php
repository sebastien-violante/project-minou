<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Repository\CatRepository;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'home')]
        public function index(
            ArticleRepository $articlesRepository,
            CatRepository $catRepository
        ): Response {
        if ($this->getUser() == null) {
            return $this->render('home/index.html.twig', [
                'articles' => $articlesRepository->findAll(),
                
            ]);}
        else {
        $email = $this->getUser()->getEmail();
                
        return $this->render('home/index.html.twig', [
            'articles' => $articlesRepository->findAll(),
            'cats' => $catRepository->findByEmail($email),
        ]);
    }
    }
    #[Route('/home/lost/{id}', name: 'catlost')]
    public function catLost(int $id, Cat $cat, EntityManagerInterface $em, CatRepository $catRepository): Response
    {
        $cat = $catRepository->findOneById($id);
        if ($cat->getIslost() == false) {
            $cat->setIslost(true);
        } else {
            $cat->setIslost(false);
        }
        $cat->setDatelost(new \DateTime());
        $em->persist($cat);
        $em->flush();

        return $this->json([
            'code' => 200,
            'message' => "changement de statut ok",
            'status' => $catRepository->findOneById($id)->getIslost()], 200);
    }

    

}
