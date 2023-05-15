<?php

namespace App\Entity;

use App\Repository\MovimientoCuentaVueloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovimientoCuentaVueloRepository::class)]
class MovimientoCuentaVuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;


    #[ORM\OneToOne(inversedBy: 'movimientoCuentaVuelo', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vuelo $vuelo = null;


    #[ORM\ManyToOne(inversedBy: 'movimientoCuentaVuelos')]
    private ?ListaPrecio $lista_precio = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoCuentaVuelos')]
    private ?Servicio $servicio = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoCuentaVuelos')]
    private ?Abono $abono = null;

    #[ORM\Column]
    private ?float $unidades_gastadas = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getListaPrecio(): ?ListaPrecio
    {
        return $this->lista_precio;
    }

    public function setListaPrecio(?ListaPrecio $lista_precio): self
    {
        $this->lista_precio = $lista_precio;

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

    public function getAbono(): ?Abono
    {
        return $this->abono;
    }

    public function setAbono(?Abono $abono): self
    {
        $this->abono = $abono;

        return $this;
    }

    public function __toString(): string
    {
        $vuelo = $this->getVuelo();

        if ($vuelo->getReservaVuelo()) {

            $matricula = $vuelo->getReservaVuelo()->getAvion()->getMatricula();
            $tipo = 'Alquier Avión '.$matricula;
        }
        else {
            $matricula = $vuelo->getAvion()->getMatricula();
            $tipo = 'Escuela de Vuelo: '.$matricula;
        }

        return sprintf('%s: %s / Costo:%s',$vuelo->getFecha()->format('Y-m-d'),$tipo,$this->getUnidadesGastadas());
    }

    public function getUnidadesGastadas(): ?float
    {
        return $this->unidades_gastadas;
    }

    public function setUnidadesGastadas(float $unidades_gastadas): self
    {
        $this->unidades_gastadas = $unidades_gastadas;

        return $this;
    }


}
