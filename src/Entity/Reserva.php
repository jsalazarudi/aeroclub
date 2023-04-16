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

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\Type("\DateTimeInterface")]
    #[Assert\NotBlank()]

    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    private ?Piloto $piloto = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    private ?Socio $socio = null;

    #[ORM\Column(nullable: true)]
    private ?bool $aprobado = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPiloto(): ?Piloto
    {
        return $this->piloto;
    }

    public function setPiloto(?Piloto $piloto): self
    {
        $this->piloto = $piloto;

        return $this;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

        return $this;
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
}
