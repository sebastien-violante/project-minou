<?php 

namespace App\Service;

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

    public function getPlace($lat, $long): array
    {
        $response = $this->client->request(
            'GET',
            'https://api.mapbox.com/geocoding/v5/mapbox.places/'.$lat.','.$long.'.json?'
        );
        
        return $response->toArray();
    }
}
