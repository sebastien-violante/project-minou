<?php

namespace App\Controller;

use Exception;
use App\Entity\Cat;
use App\Form\SearchType;
use App\Service\Apiservice;
use App\Repository\CatRepository;
use App\Repository\ArticleRepository;
use App\Repository\ReportRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
        public function index(
            ArticleRepository $articlesRepository,
            CatRepository $catRepository,
            ReportRepository $reportRepository,
            Request $request,
            Apiservice $apiservice,
        ): Response {
        if ($this->getUser() == null) {
            //partie pour le traiment du formulaire lançant la recherche des chats perdus
            $form = $this->createForm(SearchType::class);
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $coordx = $form->getData()['coordx'];
                $coordy = $form->getData()['coordy'];
                try {
                    $place = json_decode($apiservice->getPlace($coordx, $coordy), true)['locations'][0]['address']['city'];
                } catch (Exception $exception) {
                    $place = null;
                }
                $cats = $catRepository->findBy(['place' => $place, 'islost' => 'true']);
                $length = count($cats);
                return $this->render('cat/displaylost.html.twig',[
                    'cats' => $cats,
                    'place' => $place,
                    'length' => $length,
                    ]);
            }
        //////////////////////////////////////////////////////////////////////////////
            return $this->render('home/index.html.twig', [
                'articles' => $articlesRepository->findAll(),
                'form' => $form->createView(),
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
