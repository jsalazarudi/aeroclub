<?php

namespace App\Entity;

use App\Repository\ReservaVueloRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservaVueloRepository::class)]
class ReservaVuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    private ?float $duracion = null;

    #[ORM\ManyToOne(inversedBy: 'reservaVuelos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private ?Avion $avion = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Reserva $reserva = null;

    #[ORM\OneToOne(mappedBy: 'reservaVuelo', cascade: ['persist', 'remove'])]
    private ?Vuelo $vuelo = null;

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

    public function getAvion(): ?Avion
    {
        return $this->avion;
    }

    public function setAvion(?Avion $avion): self
    {
        $this->avion = $avion;

        return $this;
    }

    public function getReserva(): ?Reserva
    {
        return $this->reserva;
    }

    public function setReserva(Reserva $reserva): self
    {
        $this->reserva = $reserva;

        return $this;
    }

    public function getVuelo(): ?Vuelo
    {
        return $this->vuelo;
    }

    public function setVuelo(?Vuelo $vuelo): self
    {
        // unset the owning side of the relation if necessary
        if ($vuelo === null && $this->vuelo !== null) {
            $this->vuelo->setReservaVuelo(null);
        }

        // set the owning side of the relation if necessary
        if ($vuelo !== null && $vuelo->getReservaVuelo() !== $this) {
            $vuelo->setReservaVuelo($this);
        }

        $this->vuelo = $vuelo;

        return $this;
    }

    public function __toString(): string
    {
        return sprintf('Reserva del %s con avión %s',
            $this->getReserva()->getFechaInicio()->format('Y-m-d'),
            $this->getAvion()->getMatricula()
        );
    }


}
