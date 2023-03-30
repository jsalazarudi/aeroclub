<?php

namespace App\Entity;

use App\Repository\NotaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotaRepository::class)]
class Nota
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_recordatorio = null;

    #[ORM\ManyToOne(inversedBy: 'notas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tesorero $tesorero_id = null;

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

    public function getTesoreroId(): ?Tesorero
    {
        return $this->tesorero_id;
    }

    public function setTesoreroId(?Tesorero $tesorero_id): self
    {
        $this->tesorero_id = $tesorero_id;

        return $this;
    }
}
