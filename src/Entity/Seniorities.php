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

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Employee $employee = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $profileStartDate = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level1 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level2 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level3 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level4 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level5 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level6 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level7 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level8 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level9 = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $level10 = null;

    #[ORM\Column(length: 255)]
    private ?string $managementLevel = null;

    #[ORM\Column(length: 255)]
    private ?string $managementChain = null;

    #[ORM\Column(length: 255)]
    private ?string $seniority = null;

    #[ORM\Column(length: 255)]
    private ?string $positionId = null;

    #[ORM\Column]
    private ?bool $active = null;
    
    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): static
    {
        $this->employee = $employee;

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

    public function getLevel1(): ?string
    {
        return $this->level1;
    }

    public function setLevel1(?string $level1): static
    {
        $this->level1 = $level1;

        return $this;
    }

    public function getLevel2(): ?string
    {
        return $this->level2;
    }

    public function setLevel2(?string $level2): static
    {
        $this->level2 = $level2;

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

    public function getLevel6(): ?string
    {
        return $this->level6;
    }

    public function setLevel6(?string $level6): static
    {
        $this->level6 = $level6;

        return $this;
    }

    public function getLevel7(): ?string
    {
        return $this->level7;
    }

    public function setLevel7(?string $level7): static
    {
        $this->level7 = $level7;

        return $this;
    }

    public function getLevel8(): ?string
    {
        return $this->level8;
    }

    public function setLevel8(?string $level8): static
    {
        $this->level8 = $level8;

        return $this;
    }

    public function getLevel9(): ?string
    {
        return $this->level9;
    }

    public function setLevel9(?string $level9): static
    {
        $this->level9 = $level9;

        return $this;
    }

    public function getLevel10(): ?string
    {
        return $this->level10;
    }

    public function setLevel10(?string $level10): static
    {
        $this->level10 = $level10;

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

    public function getPositionId(): ?string
    {
        return $this->positionId;
    }

    public function setPositionId(string $positionId): static
    {
        $this->positionId = $positionId;

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
    
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
