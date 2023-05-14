<?php

namespace App\Entity;

use App\Repository\PagoMensualidadRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PagoMensualidadRepository::class)]
class PagoMensualidad
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'pagoMensualidads')]
    private ?ListaPrecio $lista_precio = null;

    #[ORM\ManyToOne(inversedBy: 'pagoMensualidads')]
    private ?Abono $abono = null;

    #[ORM\ManyToOne(inversedBy: 'pagoMensualidads')]
    private ?Mensualidad $mensualidad = null;

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

    public function getListaPrecio(): ?ListaPrecio
    {
        return $this->lista_precio;
    }

    public function setListaPrecio(?ListaPrecio $lista_precio): self
    {
        $this->lista_precio = $lista_precio;

        return $this;
    }

    public function getAbono(): ?Abono
    {
        return $this->abono;
    }

    public function setAbono(?Abono $abono): self
    {
        $this->abono = $abono;

        return $this;
    }

    public function getMensualidad(): ?Mensualidad
    {
        return $this->mensualidad;
    }

    public function setMensualidad(?Mensualidad $mensualidad): self
    {
        $this->mensualidad = $mensualidad;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFecha()->format('Y-m-d').': '.$this->getMensualidad()->getServicio()->getDescripcion();
    }

}
