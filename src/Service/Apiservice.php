<?php 

namespace App\Service;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class Apiservice
{
// création d’un client
private $client;

    // définition du client dans le constructeur
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    
    // définition de la fonction qui récupère les données
    public function getData(): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.ipgeolocation.io/ipgeo'
            
        );
        return $response->toArray();
    }

    public function getPlace($lat, $long): string
    {
        
        try {
            $response = $this->client->request(
                'GET',
                "https://api.myptv.com/geocoding/v1/locations/by-position/{$long}/{$lat}?apiKey=N2E0MWVmODFlNzk4NDc0Zjk0ZjVjN2U4NzdlYzdhZDY6MTQ3NDEzNTQtNjFhOC00YWY1LTk3NWEtNDVjZmFkYWJmZWQw"
            );
            
            return $response->getContent();
        } catch (Exception $exception) {
            throw new Exception('Localisation API error');
        }
    }
}

