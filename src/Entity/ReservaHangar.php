<?php

namespace App\Entity;

use App\Repository\ReservaHangarRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ReservaHangarRepository::class)]
class ReservaHangar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private ?Reserva $reserva = null;

    #[ORM\ManyToOne(inversedBy: 'reservaHangars')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private ?Hangar $hangar = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type("integer")]
    private ?int $dias_ocupacion = null;

    #[ORM\Column(nullable: true)]
    private ?int $unidades_gastadas = null;


    #[ORM\ManyToOne(inversedBy: 'reservaHangars')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Servicio $servicio = null;

    #[ORM\ManyToOne(inversedBy: 'reservasHangar')]
    private ?ListaPrecio $lista_precio = null;

    #[ORM\ManyToOne(inversedBy: 'reservasHangar')]
    private ?Abono $abono = null;

    public function __construct()
    {
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getHangar(): ?Hangar
    {
        return $this->hangar;
    }

    public function setHangar(?Hangar $hangar): self
    {
        $this->hangar = $hangar;

        return $this;
    }

    public function getDiasOcupacion(): ?int
    {
        return $this->dias_ocupacion;
    }

    public function setDiasOcupacion(int $dias_ocupacion): self
    {
        $this->dias_ocupacion = $dias_ocupacion;

        return $this;
    }

    public function getUnidadesGastadas(): ?int
    {
        return $this->unidades_gastadas;
    }

    public function setUnidadesGastadas(?int $unidades_gastadas): self
    {
        $this->unidades_gastadas = $unidades_gastadas;

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
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


}
