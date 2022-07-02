<?php

namespace App\Controller;

use Exception;
use App\Entity\Cat;
use App\Form\CatType;
use App\Service\Apiservice;
use App\Form\DisplayChoiceType;
use App\Repository\CatRepository;
use Symfony\Component\Mime\Address;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\DateTime;
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
    public function newCat(
        Request $request,
        ManagerRegistry $doctrine,
    ): Response 
    {
        $cat = new Cat();
        $form = $this->createForm(CatType::class, $cat);
        $form->handleRequest($request);
        $mail = $this->getUser()->getEmail();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $em= $doctrine->getManager();
            $cat->setEmail($mail);
            $cat->setIslost(false);
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
                
            }
            //traitement de la donnée ville
            $place = $form->get('place')->getData();
            ////suppression des espaces
            $place = preg_replace("/\s+/", "", $place);
            ////Forçage de la première lettre en majuscule
            $place = ucfirst($place);
            //-----------------------------//
            $cat->setPlace($place);
            $em->persist($cat);
            $em->flush();
            return $this->redirectToRoute('home');
        }
        return $this->render('cat/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    
    #[Route('/cat/lost/{id}', name: 'catlost')]
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

    /**
     * @Route("/cat/displayreport/{id}", name="displayreport")
     */
    public function displayreport(int $id, CatRepository $catRepository, ReportRepository $reportRepository): Response
    {
        $reports = $reportRepository->findBy(['cat' => $id, 'strored' => false]);
        $cat = $catRepository->findOneBy(['id' => $id]);
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        return $this->render('cat/localize.html.twig', [
            'reports' => $reports, 
            'date' => $date,
            'cat' => $cat,
        ]);
    }
}