<?php

namespace App\Service;

use App\Repository\SupOrgaRepository;
use App\Service\ApiAuthenticationService;
use Doctrine\ORM\EntityManagerInterface;

class WorkdayService
{
    public function __construct(private ApiAuthenticationService $authentication, private EntityManagerInterface $entityManager, private SupOrgaRepository $supOrgaRepository)
    {
    }

    public function jsonDecodeReport(string $report, array $parameters = []) {
        
        $decodedResponse = json_decode($this->authentication->fetchData('WD', $report, $parameters)->getContent());
        $reportEntries = $decodedResponse->Report_Entry;

        return $reportEntries;
    }

    public function employeeData(): Array {
        
        $data = $this->jsonDecodeReport('TA_-_WS_-_Employee_List');
        
        return $data;
    }

    public function supOrgaData(): Array {
        $data = $this->jsonDecodeReport('TA_-_WB_-_Integration_IDs_Sup_Org');
        
        return $data;
    }

    public function senioritiesData(): Array {
        $parameters = ['Organization_and_Superior_Organizations!WID' => $this->supOrgaRepository->findOneBy([
            'name' => 'Lyreco France',
        ])->getWorkdayId()];
        $data = $this->jsonDecodeReport('TA_-_All_Seniorities', $parameters);
        
        return $data;
    }
}