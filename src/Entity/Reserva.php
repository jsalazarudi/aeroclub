<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?bool $aprobado = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Assert\NotBlank()]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $fecha_inicio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Assert\NotBlank()]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $fecha_fin = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isAprobado(): ?bool
    {
        return $this->aprobado;
    }

    public function setAprobado(?bool $aprobado): self
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->fecha_inicio;
    }

    public function setFechaInicio(\DateTimeInterface $fecha_inicio): self
    {
        $this->fecha_inicio = $fecha_inicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->fecha_fin;
    }

    public function setFechaFin(\DateTimeInterface $fecha_fin): self
    {
        $this->fecha_fin = $fecha_fin;

        return $this;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }
}
