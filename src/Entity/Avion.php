<?php

namespace App\Entity;

use App\Repository\AvionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AvionRepository::class)]
class Avion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $matricula = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_inspeccion = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_mantenimiento = null;

    #[ORM\OneToMany(mappedBy: 'avion_id', targetEntity: Vuelo::class)]
    private Collection $vuelos;

    #[ORM\OneToMany(mappedBy: 'avion_id', targetEntity: ReservaVuelo::class)]
    private Collection $reservaVuelos;

    public function __construct()
    {
        $this->vuelos = new ArrayCollection();
        $this->reservaVuelos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricula(): ?string
    {
        return $this->matricula;
    }

    public function setMatricula(string $matricula): self
    {
        $this->matricula = $matricula;

        return $this;
    }

    public function getFechaInspeccion(): ?\DateTimeInterface
    {
        return $this->fecha_inspeccion;
    }

    public function setFechaInspeccion(\DateTimeInterface $fecha_inspeccion): self
    {
        $this->fecha_inspeccion = $fecha_inspeccion;

        return $this;
    }

    public function getFechaMantenimiento(): ?\DateTimeInterface
    {
        return $this->fecha_mantenimiento;
    }

    public function setFechaMantenimiento(\DateTimeInterface $fecha_mantenimiento): self
    {
        $this->fecha_mantenimiento = $fecha_mantenimiento;

        return $this;
    }

    /**
     * @return Collection<int, Vuelo>
     */
    public function getVuelos(): Collection
    {
        return $this->vuelos;
    }

    public function addVuelo(Vuelo $vuelo): self
    {
        if (!$this->vuelos->contains($vuelo)) {
            $this->vuelos->add($vuelo);
            $vuelo->setAvionId($this);
        }

        return $this;
    }

    public function removeVuelo(Vuelo $vuelo): self
    {
        if ($this->vuelos->removeElement($vuelo)) {
            // set the owning side to null (unless already changed)
            if ($vuelo->getAvionId() === $this) {
                $vuelo->setAvionId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ReservaVuelo>
     */
    public function getReservaVuelos(): Collection
    {
        return $this->reservaVuelos;
    }

    public function addReservaVuelo(ReservaVuelo $reservaVuelo): self
    {
        if (!$this->reservaVuelos->contains($reservaVuelo)) {
            $this->reservaVuelos->add($reservaVuelo);
            $reservaVuelo->setAvionId($this);
        }

        return $this;
    }

    public function removeReservaVuelo(ReservaVuelo $reservaVuelo): self
    {
        if ($this->reservaVuelos->removeElement($reservaVuelo)) {
            // set the owning side to null (unless already changed)
            if ($reservaVuelo->getAvionId() === $this) {
                $reservaVuelo->setAvionId(null);
            }
        }

        return $this;
    }
}
