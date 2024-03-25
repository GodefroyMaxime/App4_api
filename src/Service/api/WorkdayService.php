<?php

namespace App\Service;

use App\Entity\Employee;
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

    public function EmployeeData() {
        
        $data = $this->jsonDecodeReport('TA_-_WB_-_Employee_List');
        
        foreach ($data as $key => $value) {
            $employee = new Employee();
            $employee->setFirstname($value->firstname);
            $employee->setEmployeeId((int) $value->employee_id);
            $employee->setActive($value->active === '1' ? true : false);
            $employee->setEmployeeIdWD($value->employee_id_WD);
            $employee->setPrefLastname($value->pref_lastname);
            $employee->setPrefFirstname($value->pref_firstname);
            $employee->setLastname($value->lastname);
            $this->entityManager->persist($employee);
        }

        $this->entityManager->flush();
    }
}