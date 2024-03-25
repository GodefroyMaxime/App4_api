<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class ApiAuthenticationService
{

    public function __construct(private HttpClientInterface $client, private ParameterBagInterface $params)
    {
    }

    public function fetchData(string $api, string $report, string $format = 'json')
    {
        $environment = $_ENV['API_ENV'] ?? 'dev'; // Récupère l'environnement de l'API

        if (strtoupper($api) == 'WD') {

            // Construit les clés de paramètres en fonction du service et de l'environnement
            $baseUrlKey = $_ENV[strtoupper($api) . '_BASE_URL_' . strtoupper($environment)];
            $loginKey = $_ENV[strtoupper($api) . '_LOGIN_' . strtoupper($environment)];
            $passwordKey = $_ENV[strtoupper($api) . '_PASSWORD_' . strtoupper($environment)];

            // Utilise la configuration pour faire la requête
            $response = $this->client->request('GET', $baseUrlKey . '/' . $loginKey . '/' . $report . "?format=" . $format, [
                'auth_basic' => [$loginKey, $passwordKey],
            ]);
        } else if (strtoupper($api) == 'CEGID') {
            // En cours
        } else if (strtoupper($api) == 'KELIO') {
            // En cours
        }

        return $response;
    }
}