<?php

namespace App\Entity;

use App\Repository\SenioritiesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SenioritiesRepository::class)]
class Seniorities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'seniorities', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee_id_WD = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $profileStartDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level5 = null;

    #[ORM\Column(length: 255)]
    private ?string $managementLevel = null;

    #[ORM\Column(length: 255)]
    private ?string $managementChain = null;

    #[ORM\Column(length: 255)]
    private ?string $seniority = null;

    #[ORM\Column(length: 255)]
    private ?string $level1 = null;

    #[ORM\Column(length: 255)]
    private ?string $positionId = null;

    #[ORM\Column(length: 255)]
    private ?string $level2 = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployeeId(): ?Employee
    {
        return $this->employee_id_WD;
    }

    public function setEmployeeId(Employee $employee_id_WD): static
    {
        $this->employee_id_WD = $employee_id_WD;

        return $this;
    }

    public function getProfileStartDate(): ?\DateTimeInterface
    {
        return $this->profileStartDate;
    }

    public function setProfileStartDate(\DateTimeInterface $profileStartDate): static
    {
        $this->profileStartDate = $profileStartDate;

        return $this;
    }

    public function getLevel3(): ?string
    {
        return $this->level3;
    }

    public function setLevel3(?string $level3): static
    {
        $this->level3 = $level3;

        return $this;
    }

    public function getLevel4(): ?string
    {
        return $this->level4;
    }

    public function setLevel4(?string $level4): static
    {
        $this->level4 = $level4;

        return $this;
    }

    public function getLevel5(): ?string
    {
        return $this->level5;
    }

    public function setLevel5(?string $level5): static
    {
        $this->level5 = $level5;

        return $this;
    }

    public function getManagementLevel(): ?string
    {
        return $this->managementLevel;
    }

    public function setManagementLevel(string $managementLevel): static
    {
        $this->managementLevel = $managementLevel;

        return $this;
    }

    public function getManagementChain(): ?string
    {
        return $this->managementChain;
    }

    public function setManagementChain(string $managementChain): static
    {
        $this->managementChain = $managementChain;

        return $this;
    }

    public function getSeniority(): ?string
    {
        return $this->seniority;
    }

    public function setSeniority(string $seniority): static
    {
        $this->seniority = $seniority;

        return $this;
    }

    public function getLevel1(): ?string
    {
        return $this->level1;
    }

    public function setLevel1(string $level1): static
    {
        $this->level1 = $level1;

        return $this;
    }

    public function getPositionId(): ?string
    {
        return $this->positionId;
    }

    public function setPositionId(string $positionId): static
    {
        $this->positionId = $positionId;

        return $this;
    }

    public function getLevel2(): ?string
    {
        return $this->level2;
    }

    public function setLevel2(string $level2): static
    {
        $this->level2 = $level2;

        return $this;
    }
}
