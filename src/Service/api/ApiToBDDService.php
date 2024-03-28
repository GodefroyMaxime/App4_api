<?php

namespace App\Service;

use App\Entity\Employee;
use App\Service\WorkdayService;
use Doctrine\ORM\EntityManagerInterface;

class ApiToBDDService
{
    public function __construct(private WorkdayService $workday, private EntityManagerInterface $entityManager)
    {
    }

    public function addingEmployeeData() {
        $data = $this->workday->employeeDataRecovery();
        
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