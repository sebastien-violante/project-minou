<?php

namespace App\Controller;

use App\Entity\Cat;
use App\Form\CatType;
use App\Repository\CatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

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
    
   /*  public function newCat(
        Request $request,
        ManagerRegistry $doctrine,
        CatRepository $catRepository
    ) : Response {
        $em = $doctrine->getManager();
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $this->getUser()->getEmail();
            $cat->setEmail($email);
            $cat->setIslost(false);
            $catRepository->add($cat);
            $picture = $form->get('picture')->getData();
            dd($picture);
            if ($picture instanceof UploadedFile && $cat instanceof Cat) {
                $newFilename = 'cat' . '-' . rand(1,100000). '.' . $picture->guessExtension();
                if (is_string($this->getParameter('picture_directory'))) {
                    try {
                        $picture->move(
                            $this->getParameter('picture_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        return $this->render('errors/error500.html.twig');
                    }
                }
            }
            $cat->setPicture($newFilename);
            $email = $this->getUser()->getEmail();
            $em->persist($cat);
            $em->flush();

            return $this->redirectToRoute('home', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('cat/new.html.twig', [
            'cat' => $cat,
            'form' => $form,
        ]); 
    } */

    public function newCat(
        Request $request,
        ManagerRegistry $doctrine,
    ): Response {
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);
        $mail = $this->getUser()->getEmail();

        if ($form->isSubmitted() && $form->isValid()) {
            $em= $doctrine->getManager();
            $cat->setEmail($mail);
            
            $picture = $form->get('picture')->getData();
            if ($picture instanceof UploadedFile && $cat instanceof Cat) {
                $newFilename = 'cat' . '-' . $cat->getName() . '.' . $picture->guessExtension();
                if (is_string($this->getParameter('picture_directory'))) {
                    try {
                        $picture->move(
                            $this->getParameter('picture_directory'),
                            $newFilename
                        );
                    } catch (FileException $e) {
                        return $this->render('errors/error500.html.twig');
                    }
                }
                $cat->setPicture($newFilename);
                $cat->setIslost(false);
            }
            $em->persist($cat);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('cat/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/cat/lost/{id}', name: 'cat-lost')]
    public function catLost(EntityManagerInterface $em, int $id): Response
    {
        $cat = $em
            ->getRepository(Cat::class)
            ->findOneById($id);
        $cat->setIsLost('true');
        $em->persist($cat);
        $em->flush();
        return $this->redirectToRoute('home');
    }
}
