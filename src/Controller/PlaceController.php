<?php

namespace App\Controller;

use Exception;
use App\Service\Apiservice;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PlaceController extends AbstractController
{
    #[Route('/place/{lat}/{long}', name: 'place')]
    public function place(
        float $lat,
        float $long,
        Apiservice $apiService,
    ): Response
    {
        try {
            $details = $apiService->getPlace($lat, $long);
        } catch (Exception $exception) {
            $details = null;
        }
        return $this->render('cat/displaychoice.html.twig', [
            'details' => $details,
        ]);
    }
}
