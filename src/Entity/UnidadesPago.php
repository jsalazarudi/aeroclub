<?php

namespace App\Entity;

use App\Repository\UnidadesPagoRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UnidadesPagoRepository::class)]
class UnidadesPago
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $unidad_relativa = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'unidadesPagos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Servicio $servicio = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnidadRelativa(): ?int
    {
        return $this->unidad_relativa;
    }

    public function setUnidadRelativa(int $unidad_relativa): self
    {
        $this->unidad_relativa = $unidad_relativa;

        return $this;
    }

    public function getFecha(): ?\DateTimeInterface
    {
        return $this->fecha;
    }

    public function setFecha(\DateTimeInterface $fecha): self
    {
        $this->fecha = $fecha;

        return $this;
    }

    public function getServicio(): ?Servicio
    {
        return $this->servicio;
    }

    public function setServicio(?Servicio $servicio): self
    {
        $this->servicio = $servicio;

        return $this;
    }
}
