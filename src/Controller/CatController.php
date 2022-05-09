<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Form\CatType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CatController extends AbstractController
{
    #[Route('/cat', name: 'cat')]
    public function index(): Response
    {
        return $this->render('cat/index.html.twig', [
            'controller_name' => 'CatController',
        ]);
    }

    #[Route('/cat/new', name: 'new_cat')]
    public function newCat(Request $request, EntityManagerInterface $entityManager) : Response
    {
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);
        /* $email = $this->getUser()->getEmail(); */
        if ($form->isSubmitted() && $form->isValid()) {
            $cat->setEmail($email);
            /* $cat->setColorStyle(()); */
            $entityManager->persist($cat);
            $entityManager->flush();
            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cat/new.html.twig', [
            'cat' => $cat,
            'form' => $form,
        ]);
    }
}
