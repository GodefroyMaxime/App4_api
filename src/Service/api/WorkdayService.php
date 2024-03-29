<?php

namespace App\Service;

use App\Service\ApiAuthenticationService;
use Doctrine\ORM\EntityManagerInterface;

class WorkdayService
{
    public function __construct(private ApiAuthenticationService $authentication, private EntityManagerInterface $entityManager)
    {
    }

    public function jsonDecodeReport(string $report) {
        
        $decodedResponse = json_decode($this->authentication->fetchData('WD', $report)->getContent());
        $reportEntries = $decodedResponse->Report_Entry;

        return $reportEntries;
    }

    public function employeeData(): Array {
        
        $data = $this->jsonDecodeReport('TA_-_WS_-_Employee_List');
        
        return $data;
    }
}