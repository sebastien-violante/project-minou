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
    
    #[Route('/cat/lost/{id}', name: 'cat-lost')]
    public function catLost(EntityManagerInterface $em, int $id): Response
    {
        $cat = $em
            ->getRepository(Cat::class)
            ->findOneById($id);
        if($cat->getIsLost() == true) {
            $cat->setIsLost(false); 
        } else {
            $cat->setIsLost(true);
        }
            $em->persist($cat);
            $em->flush();
            return $this->redirectToRoute('home');
    }

    #[Route('/cat/displaychoice', name: 'displaychoice')]
    public function displaychoice(
        Request $request,
        CatRepository $catRepository,
        Apiservice $getPlace,
    ): Response 
    {
        
        if($request->request->count() > 0) {
            $place = $request->request->get('Ville');
            $color1 = $request->request->get('color1');
            $color2 = $request->request->get('color2');
            $color3 = $request->request->get('color3');
            $lat=47;
            $long=0.6;
            $cats = $catRepository->findBy(
                ['place' => $place,
                'islost' => true]);
            try {
                $town = json_decode($townapi->getData($lat, $long));
                
            } catch (Exception $exception) {
                $place = null;
            }
            
            return $this->render('cat/displaylost.html.twig', [
                'cats' => $cats,
                'place' => $place,
            ]);
        }
        return $this->render('cat/displaychoice.html.twig', [
            
        ]);
    }

     
    /* #[Route('/cat/displaylost', name: 'displaylost')]
    public function displayLost(float $lat, float $long, Apiservice $apiservice): Response 
    {
        try {
            $details = json_decode($apiservice->getPlace($lat, $long), true);
        } catch (Exception $exception) {
            $details = null;
        }
       

        return $this->render('cat/displaylost.html.twig', [
            
        ]);
    }
 */
    /**
     * @Route("/cat/displayreport/{id}", name="displayreport")
     */
   public function displayreport(int $id, CatRepository $catRepository, ReportRepository $reportRepository): Response
    {
        $reports = $reportRepository->findBy(['cat' => $id]);
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