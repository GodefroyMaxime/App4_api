<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ApiAuthenticationService
{
    private $client;
    private $params;

    public function __construct(HttpClientInterface $client, ParameterBagInterface $params)
    {
        $this->client = $client;
        $this->params = $params;
    }

    public function fetchData(string $api, string $report, string $format = 'json')
    {
        $environment = $_ENV['API_ENV'] ?? 'dev'; // Récupère l'environnement de l'API

        if (strtoupper($api) == 'WD') {

            // Construit les clés de paramètres en fonction du service et de l'environnement
            $baseUrlKey = strtoupper($api) . '_BASE_URL_' . strtoupper($environment);
            $loginKey = strtoupper($api) . '_LOGIN_' . strtoupper($environment);
            $passwordKey = strtoupper($api) . '_PASSWORD_' . strtoupper($environment);

            $baseUrl = $this->params->get($baseUrlKey);
            $login = $this->params->get($loginKey);
            $password = $this->params->get($passwordKey);

            // Utilise la configuration pour faire la requête
            $response = $this->client->request('GET', $baseUrl . '/' . $report, [
                'format' => $format,
                'auth_basic' => [$login, $password],
            ]);
        } else if (strtoupper($api) == 'CEGID') {
            
        } else if (strtoupper($api) == 'KELIO') {
            
        }

        return $response;
    }
}