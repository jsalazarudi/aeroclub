<?php

namespace App\Entity;

use App\Repository\CuentaCorrienteRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CuentaCorrienteRepository::class)]
class CuentaCorriente
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?int $deuda_remanente = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrientes')]
    private ?MovimientoCuentaVuelo $movimiento_cuenta_vuelo_id = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrientes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?ListaPrecio $lista_precio_id = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrientes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Abono $abono_id = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrientes')]
    private ?Venta $venta_id = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrientes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Servicio $servicio_id = null;

    #[ORM\ManyToOne(inversedBy: 'cuentaCorrientes')]
    private ?ReservaHangar $reserva_hangar_id = null;

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

    public function getDeudaRemanente(): ?int
    {
        return $this->deuda_remanente;
    }

    public function setDeudaRemanente(int $deuda_remanente): self
    {
        $this->deuda_remanente = $deuda_remanente;

        return $this;
    }

    public function getMovimientoCuentaVueloId(): ?MovimientoCuentaVuelo
    {
        return $this->movimiento_cuenta_vuelo_id;
    }

    public function setMovimientoCuentaVueloId(?MovimientoCuentaVuelo $movimiento_cuenta_vuelo_id): self
    {
        $this->movimiento_cuenta_vuelo_id = $movimiento_cuenta_vuelo_id;

        return $this;
    }

    public function getListaPrecioId(): ?ListaPrecio
    {
        return $this->lista_precio_id;
    }

    public function setListaPrecioId(?ListaPrecio $lista_precio_id): self
    {
        $this->lista_precio_id = $lista_precio_id;

        return $this;
    }

    public function getAbonoId(): ?Abono
    {
        return $this->abono_id;
    }

    public function setAbonoId(?Abono $abono_id): self
    {
        $this->abono_id = $abono_id;

        return $this;
    }

    public function getVentaId(): ?Venta
    {
        return $this->venta_id;
    }

    public function setVentaId(?Venta $venta_id): self
    {
        $this->venta_id = $venta_id;

        return $this;
    }

    public function getServicioId(): ?Servicio
    {
        return $this->servicio_id;
    }

    public function setServicioId(?Servicio $servicio_id): self
    {
        $this->servicio_id = $servicio_id;

        return $this;
    }

    public function getReservaHangarId(): ?ReservaHangar
    {
        return $this->reserva_hangar_id;
    }

    public function setReservaHangarId(?ReservaHangar $reserva_hangar_id): self
    {
        $this->reserva_hangar_id = $reserva_hangar_id;

        return $this;
    }
}
