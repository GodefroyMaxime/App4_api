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

    public function updateEmployeeList(): Array {
        $data = $this->workday->employeeData();
        $update = [];
        $update['create'] = [];
        $update['history'] = [];
        $update['update'] = [];
        
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

                $update['create'] += [$dataValue->employeeId => date('Y-m-d H:i:s')];
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

                    $existingMatricule->setFirstname($dataValue->firstname);
                    $existingMatricule->setEmployeeId($dataValue->employeeId);
                    $existingMatricule->setActive($dataValue->active === '1' ? true : false);
                    $existingMatricule->setEmployeeIdWD($dataValue->employeeIdWD);
                    $existingMatricule->setPrefLastname($dataValue->prefLastname);
                    $existingMatricule->setPrefFirstname($dataValue->prefFirstname);
                    $existingMatricule->setLastname($dataValue->lastname);
                    $this->entityManager->persist($existingMatricule);

                    $update['history'] += [$existingMatricule->getEmployeeId() => date('Y-m-d H:i:s')];
                    $update['update'] += [$dataValue->employeeId => date('Y-m-d H:i:s')];
                }
            }
        }

        $this->entityManager->flush();

        return $update;
    }
    
    public function updateSupOrgaList(): Array {
        $data = $this->workday->supOrgaData();
        $update = [];
        $update['create'] = [];
        $update['history'] = [];
        $update['update'] = [];
        
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
                
                $update['create'] += [$dataValue->name => date('Y-m-d H:i:s')];
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
                    
                    $update['history'] += [$existingSupOrga->getName() => date('Y-m-d H:i:s')];
                    $update['update'] += [$dataValue->name => date('Y-m-d H:i:s')];
                }
            }
        }

        $this->entityManager->flush();

        return $update;
    }

    public function updateSenioritiesList(): Array {
        $data = $this->workday->senioritiesData();
        $update = [];
        $update['create'] = [];
        $update['history'] = [];
        $update['update'] = [];
        
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
                if (isset($dataValue->level6)) {
                    $employeeSeniority->setLevel6($dataValue->level6);
                }
                if (isset($dataValue->level7)) {
                    $employeeSeniority->setLevel7($dataValue->level7);
                }
                if (isset($dataValue->level8)) {
                    $employeeSeniority->setLevel8($dataValue->level8);
                }
                if (isset($dataValue->level9)) {
                    $employeeSeniority->setLevel9($dataValue->level9);
                }
                if (isset($dataValue->level10)) {
                    $employeeSeniority->setLevel10($dataValue->level10);
                }
                $employeeSeniority->setManagementLevel($dataValue->managementLevel);
                $employeeSeniority->setManagementChain($dataValue->managementChain);
                $employeeSeniority->setSeniority($dataValue->seniority);
                $employeeSeniority->setPositionId($dataValue->positionId);
                $employeeSeniority->setActive('1');
                $employeeSeniority->setCreatedAt(new \DateTime());
                $this->entityManager->persist($employeeSeniority);

                
                $update['create'] += [$employee->getEmployeeId() => date('Y-m-d H:i:s')];
            } else {
                $lastData = $this->normalizer->normalize($existingEmployeeSeniority);
                $lastData += ['employeeId' => $lastData['employee']['employeeIdWD']];
                $profileStartDate = new \DateTime($lastData['profileStartDate']);
                $lastData['profileStartDate'] = $profileStartDate->format('Y-m-d');
                unset($lastData['id'], $lastData['active'], $lastData['createdAt'], $lastData['employee']);

                $newDataValue = (array)$dataValue;

                if ($lastData['level1'] == null && !isset($newDataValue['level1'])) {
                    unset($lastData['level1']);
                }
                if ($lastData['level2'] == null && !isset($newDataValue['level2'])) {
                    unset($lastData['level2']);
                }
                if ($lastData['level3'] == null && !isset($newDataValue['level3'])) {
                    unset($lastData['level3']);
                }
                if ($lastData['level4'] == null && !isset($newDataValue['level4'])) {
                    unset($lastData['level4']);
                }
                if ($lastData['level5'] == null && !isset($newDataValue['level5'])) {
                    unset($lastData['level5']);
                }
                if ($lastData['level6'] == null && !isset($newDataValue['level6'])) {
                    unset($lastData['level6']);
                }
                if ($lastData['level7'] == null && !isset($newDataValue['level7'])) {
                    unset($lastData['level7']);
                }
                if ($lastData['level8'] == null && !isset($newDataValue['level8'])) {
                    unset($lastData['level8']);
                }
                if ($lastData['level9'] == null && !isset($newDataValue['level9'])) {
                    unset($lastData['level9']);
                }
                if ($lastData['level10'] == null && !isset($newDataValue['level10'])) {
                    unset($lastData['level10']);
                }

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
                    if (isset($dataValue->level6)) {
                        $employeeSeniority->setLevel6($dataValue->level6);
                    }
                    if (isset($dataValue->level7)) {
                        $employeeSeniority->setLevel7($dataValue->level7);
                    }
                    if (isset($dataValue->level8)) {
                        $employeeSeniority->setLevel8($dataValue->level8);
                    }
                    if (isset($dataValue->level9)) {
                        $employeeSeniority->setLevel9($dataValue->level9);
                    }
                    if (isset($dataValue->level10)) {
                        $employeeSeniority->setLevel10($dataValue->level10);
                    }
                    $employeeSeniority->setManagementLevel($dataValue->managementLevel);
                    $employeeSeniority->setManagementChain($dataValue->managementChain);
                    $employeeSeniority->setSeniority($dataValue->seniority);
                    $employeeSeniority->setPositionId($dataValue->positionId);
                    $employeeSeniority->setActive('1');
                    $employeeSeniority->setCreatedAt(new \DateTime());
                    $this->entityManager->persist($employeeSeniority);
                    
                    $update['history'] += [$existingEmployeeSeniority->getEmployee()->getEmployeeId() => date('Y-m-d H:i:s')];
                    $update['update'] += [$employee->getEmployeeId() => date('Y-m-d H:i:s')];
                }
            }
        }

        $this->entityManager->flush();

        return $update;
    }
}