<?php 

namespace App\service;

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
            'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=47.383518822307295&lon=0.667626237627049&zoom=10'
        );
        return $response->toArray();
    }
}
