<?php

namespace App\Service;

use App\Entity\Employee;
use App\Entity\EmployeeHistory;
use App\Entity\Seniorities;
use App\Entity\SupOrga;
use App\Repository\EmployeeRepository;
use App\Repository\SenioritiesRepository;
use App\Repository\SupOrgaRepository;
use App\Service\WorkdayService;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Framework\Constraint\ObjectHasProperty;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ApiToBDDService
{
    public function __construct(private WorkdayService $workday, 
                                private EmployeeRepository $employeeRepository, 
                                private SupOrgaRepository $supOrgaRepository, 
                                private SenioritiesRepository $senioritiesRepository,
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
                'active' => 1,
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

    public function updateSenioritiesList() {

        $data = $this->workday->senioritiesData();
        
        foreach ($data as $dataKey => $dataValue) {
            $employee = $this->employeeRepository->findOneBy([
                'employee_id' => (int)$dataValue->employeeId,
            ]);

            $existingEmployeeSeniority = $this->senioritiesRepository->findOneBy([
                'employee' => $employee,
                'active' => 1,
            ]);

            if (!$existingEmployeeSeniority) {
                $employeeSeniority = new Seniorities();
                $employeeSeniority->setEmployee($employee);
                $employeeSeniority->setProfileStartDate(new \DateTime($dataValue->profileStartDate));
                if (isset($dataValue->level1)) {
                    $employeeSeniority->setLevel1($dataValue->level1);
                }
                if (isset($dataValue->level2)) {
                    $employeeSeniority->setLevel2($dataValue->level2);
                }
                if (isset($dataValue->level3)) {
                    $employeeSeniority->setLevel3($dataValue->level3);
                }
                if (isset($dataValue->level4)) {
                    $employeeSeniority->setLevel4($dataValue->level4);
                }
                if (isset($dataValue->level5)) {
                    $employeeSeniority->setLevel5($dataValue->level5);
                }
                $employeeSeniority->setManagementLevel($dataValue->managementLevel);
                $employeeSeniority->setManagementChain($dataValue->managementChain);
                $employeeSeniority->setSeniority($dataValue->seniority);
                $employeeSeniority->setPositionId($dataValue->positionId);
                $employeeSeniority->setActive('1');
                $employeeSeniority->setCreatedAt(new \DateTime());
                $this->entityManager->persist($employeeSeniority);
            } else {
                $lastData = $this->normalizer->normalize($existingEmployeeSeniority);
                $lastData += ['employeeId' => $lastData['employee']['employeeIdWD']];
                $profileStartDate = new \DateTime($lastData['profileStartDate']);
                $lastData['profileStartDate'] = $profileStartDate->format('Y-m-d');
                unset($lastData['id'], $lastData['active'], $lastData['createdAt'], $lastData['employee']);
                if ($lastData['level1'] == null) {
                    unset($lastData['level1']);
                }
                if ($lastData['level2'] == null) {
                    unset($lastData['level2']);
                }
                if ($lastData['level3'] == null) {
                    unset($lastData['level3']);
                }
                if ($lastData['level4'] == null) {
                    unset($lastData['level4']);
                }
                if ($lastData['level5'] == null) {
                    unset($lastData['level5']);
                }
                
                $newDataValue = (array)$dataValue;

                $differences = array_diff_assoc($lastData, $newDataValue);
                if ($differences) {
                    $existingEmployeeSeniority->setActive(0);
                    
                    $employeeSeniority = new Seniorities();
                    $employeeSeniority->setEmployee($employee);
                    $employeeSeniority->setProfileStartDate(new \DateTime($dataValue->profileStartDate));
                    if (isset($dataValue->level1)) {
                        $employeeSeniority->setLevel1($dataValue->level1);
                    }
                    if (isset($dataValue->level2)) {
                        $employeeSeniority->setLevel2($dataValue->level2);
                    }
                    if (isset($dataValue->level3)) {
                        $employeeSeniority->setLevel3($dataValue->level3);
                    }
                    if (isset($dataValue->level4)) {
                        $employeeSeniority->setLevel4($dataValue->level4);
                    }
                    if (isset($dataValue->level5)) {
                        $employeeSeniority->setLevel5($dataValue->level5);
                    }
                    $employeeSeniority->setManagementLevel($dataValue->managementLevel);
                    $employeeSeniority->setManagementChain($dataValue->managementChain);
                    $employeeSeniority->setSeniority($dataValue->seniority);
                    $employeeSeniority->setPositionId($dataValue->positionId);
                    $employeeSeniority->setActive('1');
                    $employeeSeniority->setCreatedAt(new \DateTime());
                    $this->entityManager->persist($employeeSeniority);
                }
            }
        }

        $this->entityManager->flush();
    }
}