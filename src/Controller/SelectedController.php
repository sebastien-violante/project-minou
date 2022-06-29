<?php

namespace App\Controller;

use App\Form\SelectedFormType;
use App\Repository\CatRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SelectedController extends AbstractController
{
    #[Route('/selected', name: 'app_selected')]
    public function index(
        Request $request,
        CatRepository $catRepository,
    ): Response
    {
        $form = $this->createForm(SelectedFormType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $colortype = $form->getData()['colortype'];
         /*    traitement de la requete pour récuérer les résultats */
            $place = 'Fondettes';
           /*  $length = count($cats); */
            return $this->render('cat/displaylost.html.twig',[
               /*  'cats' => $cats, */
                'place' => $place,
                /* 'length' => $length, */
                ]);
        }
        $place ="Fondettes";
        return $this->render('selected/index.html.twig');
    //////////////////////////////////////////////////////////////////////////////
    }
}
