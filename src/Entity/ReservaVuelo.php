<?php

namespace App\Entity;

use App\Repository\ReservaVueloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservaVueloRepository::class)]
class ReservaVuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $duracion = null;

    #[ORM\ManyToOne(inversedBy: 'reservaVuelos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avion $avion_id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reserva $reserva_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDuracion(): ?float
    {
        return $this->duracion;
    }

    public function setDuracion(float $duracion): self
    {
        $this->duracion = $duracion;

        return $this;
    }

    public function getAvionId(): ?Avion
    {
        return $this->avion_id;
    }

    public function setAvionId(?Avion $avion_id): self
    {
        $this->avion_id = $avion_id;

        return $this;
    }

    public function getReservaId(): ?Reserva
    {
        return $this->reserva_id;
    }

    public function setReservaId(Reserva $reserva_id): self
    {
        $this->reserva_id = $reserva_id;

        return $this;
    }
}
