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
            'https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=47.34&lon=0.45&zoom=18'
            /* 'https://api-adresse.data.gouv.fr/search/?q=lat=47.3269&lon=0.4061' */
            /* 'http://api.positionstack.com/v1/forward?access_key=d991fb578866be9dcdc2e56356129e20&query=0.68,47.4&output=json' */
        );
        return $response->toArray();
    }
}
