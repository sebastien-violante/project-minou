<?php

namespace App\Controller;

use App\Repository\CatRepository;
use App\Form\DisconnectedSearchType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class DisconnectedController extends AbstractController
{
    #[Route('/disconnected', name: 'app_disconnected')]
    public function index(
        CatRepository $catRepository,
        Request $request,
    ): Response
    {
        $form = $this->createForm(DisconnectedSearchType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //traitement de la donnée ville
            $place = $form->get('place')->getData();
            ////suppression des espaces
            $place = preg_replace("/\s+/", "", $place);
            ////Forçage de la première lettre en majuscule
            $place = ucfirst($place);
            $cats=$catRepository->findBy(['place' => $place, 'islost' => 'true']);
            $length = count($cats);
            return $this->render('cat/displaylost.html.twig',[
                'cats' => $cats,
                'place' => $place,
                'length' => $length,
                ]);
        }
        return $this->render('disconnected/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
