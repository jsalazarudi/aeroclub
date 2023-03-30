<?php

namespace App\Entity;

use App\Repository\ReservaRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaRepository::class)]
class Reserva
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    private ?Piloto $piloto_id = null;

    #[ORM\ManyToOne(inversedBy: 'reservas')]
    private ?Socio $socio_id = null;

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

    public function getPilotoId(): ?Piloto
    {
        return $this->piloto_id;
    }

    public function setPilotoId(?Piloto $piloto_id): self
    {
        $this->piloto_id = $piloto_id;

        return $this;
    }

    public function getSocioId(): ?Socio
    {
        return $this->socio_id;
    }

    public function setSocioId(?Socio $socio_id): self
    {
        $this->socio_id = $socio_id;

        return $this;
    }
}
