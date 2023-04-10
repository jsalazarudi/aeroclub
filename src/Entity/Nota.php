<?php

namespace App\Entity;

use App\Repository\NotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: NotaRepository::class)]
class Nota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type('DateTime')]
    private ?\DateTimeInterface $fecha_recordatorio = null;

    #[ORM\ManyToOne(inversedBy: 'notas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tesorero $tesorero = null;

    #[ORM\Column]
    private ?bool $realizado = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaRecordatorio(): ?\DateTimeInterface
    {
        return $this->fecha_recordatorio;
    }

    public function setFechaRecordatorio(\DateTimeInterface $fecha_recordatorio): self
    {
        $this->fecha_recordatorio = $fecha_recordatorio;

        return $this;
    }

    public function getTesorero(): ?Tesorero
    {
        return $this->tesorero;
    }

    public function setTesorero(?Tesorero $tesorero): self
    {
        $this->tesorero = $tesorero;

        return $this;
    }

    public function isRealizado(): ?bool
    {
        return $this->realizado;
    }

    public function setRealizado(bool $realizado): self
    {
        $this->realizado = $realizado;

        return $this;
    }
}
