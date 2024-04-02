<?php

namespace App\Service;

use Exception;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;

class ApiAuthenticationService
{

    public function __construct(private HttpClientInterface $client, private ParameterBagInterface $params)
    {
    }

    public function fetchData(string $api, string $report, array $parameters = [], string $format = 'json')
    {
        $environment = $_ENV['API_ENV'] ?? 'dev'; // Récupère l'environnement de l'API
        $response = [];
    
        try {
            if (strtoupper($api) == 'WD') {
                // Construit les clés de paramètres en fonction du service et de l'environnement
                $baseUrlKey = $_ENV[strtoupper($api) . '_BASE_URL_' . strtoupper($environment)];
                $loginKey = $_ENV[strtoupper($api) . '_LOGIN_' . strtoupper($environment)];
                $passwordKey = $_ENV[strtoupper($api) . '_PASSWORD_' . strtoupper($environment)];
                
                $parametersQueryString = http_build_query($parameters); // Construit le string de paramètres
            
                // Ajoute le format comme dernier paramètre
                $parametersQueryString .= (empty($parametersQueryString) ? '' : '&') . "format=" . $format;
                
                // Utilise la configuration pour faire la requête
                $response = $this->client->request('GET', $baseUrlKey . '/' . $loginKey . '/' . $report . "?" . $parametersQueryString, [
                    'auth_basic' => [$loginKey, $passwordKey],
                ]);
            } else if (strtoupper($api) == 'CEGID') {
                // En cours
            } else if (strtoupper($api) == 'KELIO') {
                // En cours
            }
        } catch (ClientExceptionInterface $e) {
            throw new Exception("Erreur côté client lors de la requête à l'API : " . $e->getMessage(), 0, $e);
        } catch (ServerExceptionInterface $e) {
            throw new Exception("Erreur côté serveur lors de la requête à l'API : " . $e->getMessage(), 0, $e);
        }
    
        return $response;
    }
}