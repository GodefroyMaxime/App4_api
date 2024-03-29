<?php

namespace App\Service;

use App\Entity\Employee;
use App\Entity\EmployeeHistory;
use App\Repository\EmployeeRepository;
use App\Service\WorkdayService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiToBDDService
{
    public function __construct(private WorkdayService $workday, private EmployeeRepository $employeeRepository, private EntityManagerInterface $entityManager, private NormalizerInterface $normalizer)
    {
    }

    public function updateEmployeeList() {
        $data = $this->workday->employeeData();
        
        foreach ($data as $dataKey => $dataValue) {

            $existingMatricule = $this->employeeRepository->findOneBy([
                'employee_id' => $dataValue->employeeId,
            ]);

            // $dynamicsVariables = [];

            // foreach ($dataValue as $key => $value) {
            //     try {
            //         array_push($dynamicsVariables, $key);
            //     } catch  (\Throwable $e) {
            //     }
            // }

            if(!$existingMatricule) {
                $employee = new Employee();
                $employee->setFirstname($dataValue->firstname);
                $employee->setEmployeeId($dataValue->employeeId);
                $employee->setActive($dataValue->active === '1' ? true : false);
                $employee->setEmployeeIdWD($dataValue->employeeIdWD);
                $employee->setPrefLastname($dataValue->prefLastname);
                $employee->setPrefFirstname($dataValue->prefFirstname);
                $employee->setLastname($dataValue->lastname);
                $this->entityManager->persist($employee);
            } else {
                $lastData = $this->normalizer->normalize($existingMatricule);
                unset($lastData['id']);
                
                $lastData['active'] = $lastData['active'] === true ? "1" : "0";
                $newDataValue = (array)$dataValue;

                $differences = array_diff_assoc($lastData, $newDataValue);
                if ($differences) {
                    $employeeHistory = new EmployeeHistory();
                    $employeeHistory->setFirstname($existingMatricule->getFirstname());
                    $employeeHistory->setEmployeeId($existingMatricule->getEmployeeId());
                    $employeeHistory->setActive($existingMatricule->isActive() === '1' ? true : false);
                    $employeeHistory->setEmployeeIdWD($existingMatricule->getEmployeeIdWD());
                    $employeeHistory->setPrefLastname($existingMatricule->getPrefLastname());
                    $employeeHistory->setPrefFirstname($existingMatricule->getPrefFirstname());
                    $employeeHistory->setLastname($existingMatricule->getLastname());
                    $employeeHistory->setCreated_at(new \DateTime());
                    $this->entityManager->persist($employeeHistory);

                    $this->entityManager->remove($existingMatricule);

                    $employee = new Employee();
                    $employee->setFirstname($dataValue->firstname);
                    $employee->setEmployeeId($dataValue->employeeId);
                    $employee->setActive($dataValue->active === '1' ? true : false);
                    $employee->setEmployeeIdWD($dataValue->employeeIdWD);
                    $employee->setPrefLastname($dataValue->prefLastname);
                    $employee->setPrefFirstname($dataValue->prefFirstname);
                    $employee->setLastname($dataValue->lastname);
                    $this->entityManager->persist($employee);
                }
            }
        }

        $this->entityManager->flush();
    }
}