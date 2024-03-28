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

    public function employeeDataRecovery(): Array {
        
        $data = $this->jsonDecodeReport('TA_-_WB_-_Employee_List');
        
        return $data;
    }
}