<?php

namespace App\Service;

use App\Entity\Employee;
use App\Entity\EmployeeHistory;
use App\Entity\SupOrga;
use App\Repository\EmployeeRepository;
use App\Repository\SupOrgaRepository;
use App\Service\WorkdayService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiToBDDService
{
    public function __construct(private WorkdayService $workday, 
                                private EmployeeRepository $employeeRepository, 
                                private SupOrgaRepository $supOrgaRepository, 
                                private EntityManagerInterface $entityManager, 
                                private NormalizerInterface $normalizer)
    {
    }

    public function updateEmployeeList() {
        $data = $this->workday->employeeData();
        
        foreach ($data as $dataKey => $dataValue) {

            $existingMatricule = $this->employeeRepository->findOneBy([
                'employee_id' => $dataValue->employeeId,
            ]);

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
    
    public function updateSupOrgaList() {
        $data = $this->workday->supOrgaData();
        
        foreach ($data as $dataKey => $dataValue) {
            $existingSupOrga = $this->supOrgaRepository->findOneBy([
                'workdayId' => $dataValue->workdayId,
            ]);

            if (!$existingSupOrga) {
                $supOrga = new SupOrga();
                $supOrga->setName($dataValue->name);
                $supOrga->setWorkdayId($dataValue->workdayId);
                $supOrga->setActive('1');
                $supOrga->setCreatedAt(new \DateTime());
                $this->entityManager->persist($supOrga);
            } else {
                $lastData = $this->normalizer->normalize($existingSupOrga);
                unset($lastData['id'], $lastData['active'], $lastData['createdAt']);
                
                $newDataValue = (array)$dataValue;

                $differences = array_diff_assoc($lastData, $newDataValue);
                if ($differences) {
                    $existingSupOrga->setActive(0);
                    
                    $supOrga = new SupOrga();
                    $supOrga->setName($dataValue->name);
                    $supOrga->setWorkdayId($dataValue->workdayId);
                    $supOrga->setActive('1');
                    $supOrga->setCreatedAt(new \DateTime());
                    $this->entityManager->persist($supOrga);
                }
            }
        }

        $this->entityManager->flush();
    }
}