<?php

namespace App\Entity;

use App\Repository\VueloPlaneadorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VueloPlaneadorRepository::class)]
class VueloPlaneador
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $tiempo_remolque = null;

    #[ORM\Column]
    private ?float $tiempo_libre = null;

    #[ORM\Column(length: 255)]
    private ?string $tema_vuelo = null;

    #[ORM\Column]
    private ?float $tiempo_acumulado = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vuelo $vuelo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTiempoRemolque(): ?float
    {
        return $this->tiempo_remolque;
    }

    public function setTiempoRemolque(float $tiempo_remolque): self
    {
        $this->tiempo_remolque = $tiempo_remolque;

        return $this;
    }

    public function getTiempoLibre(): ?float
    {
        return $this->tiempo_libre;
    }

    public function setTiempoLibre(float $tiempo_libre): self
    {
        $this->tiempo_libre = $tiempo_libre;

        return $this;
    }

    public function getTemaVuelo(): ?string
    {
        return $this->tema_vuelo;
    }

    public function setTemaVuelo(string $tema_vuelo): self
    {
        $this->tema_vuelo = $tema_vuelo;

        return $this;
    }

    public function getTiempoAcumulado(): ?float
    {
        return $this->tiempo_acumulado;
    }

    public function setTiempoAcumulado(float $tiempo_acumulado): self
    {
        $this->tiempo_acumulado = $tiempo_acumulado;

        return $this;
    }

    public function getVuelo(): ?Vuelo
    {
        return $this->vuelo;
    }

    public function setVuelo(Vuelo $vuelo): self
    {
        $this->vuelo = $vuelo;

        return $this;
    }
}
