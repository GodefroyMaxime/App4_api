<?php

namespace App\Entity;

use App\Repository\SupOrgaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SupOrgaRepository::class)]
class SupOrga
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $wordayId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getWordayId(): ?string
    {
        return $this->wordayId;
    }

    public function setWordayId(string $wordayId): static
    {
        $this->wordayId = $wordayId;

        return $this;
    }
}
