<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column]
    private ?int $employee_id = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 255)]
    private ?string $employee_id_WD = null;

    #[ORM\Column(length: 255)]
    private ?string $pref_lastname = null;

    #[ORM\Column(length: 255)]
    private ?string $pref_firstname = null;

    #[ORM\Column(length: 255)]
    private ?string $lastname = null;

    #[ORM\OneToOne(mappedBy: 'employee', cascade: ['persist', 'remove'])]
    private ?Seniorities $seniorities = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getEmployeeId(): ?int
    {
        return $this->employee_id;
    }

    public function setEmployeeId(int $employee_id): static
    {
        $this->employee_id = $employee_id;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getEmployeeIdWD(): ?string
    {
        return $this->employee_id_WD;
    }

    public function setEmployeeIdWD(string $employee_id_WD): static
    {
        $this->employee_id_WD = $employee_id_WD;

        return $this;
    }

    public function getPrefLastname(): ?string
    {
        return $this->pref_lastname;
    }

    public function setPrefLastname(string $pref_lastname): static
    {
        $this->pref_lastname = $pref_lastname;

        return $this;
    }

    public function getPrefFirstname(): ?string
    {
        return $this->pref_firstname;
    }

    public function setPrefFirstname(string $pref_firstname): static
    {
        $this->pref_firstname = $pref_firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getSeniorities(): ?Seniorities
    {
        return $this->seniorities;
    }

    public function setSeniorities(Seniorities $seniorities): static
    {
        // set the owning side of the relation if necessary
        if ($seniorities->getEmployee() !== $this) {
            $seniorities->setEmployee($this);
        }

        $this->seniorities = $seniorities;

        return $this;
    }
}
