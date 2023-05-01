<?php

namespace App\Entity;

use App\Repository\ListaPrecioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ListaPrecioRepository::class)]
class ListaPrecio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type("integer")]
    private ?int $precio = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    #[Assert\NotBlank()]
    private ?HistorialListaPrecio $historial_lista_precio = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?Servicio $servicio = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?Producto $producto = null;

    #[ORM\OneToMany(mappedBy: 'lista_precio_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    #[ORM\Column]
    private ?bool $socio = null;

    #[ORM\OneToMany(mappedBy: 'lista_precio', targetEntity: ReservaHangar::class)]
    private Collection $reservasHangar;

    #[ORM\OneToMany(mappedBy: 'lista_precio', targetEntity: MovimientoCuentaVuelo::class)]
    private Collection $movimientoCuentaVuelos;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?Avion $avion = null;

    #[ORM\Column(nullable: true)]
    private ?bool $alumno = null;

    #[ORM\OneToMany(mappedBy: 'lista_precio', targetEntity: Venta::class)]
    private Collection $ventas;

    #[ORM\Column]
    private ?bool $bautismo = null;

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
        $this->reservasHangar = new ArrayCollection();
        $this->movimientoCuentaVuelos = new ArrayCollection();
        $this->ventas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getHistorialListaPrecio(): ?HistorialListaPrecio
    {
        return $this->historial_lista_precio;
    }

    public function setHistorialListaPrecio(?HistorialListaPrecio $historial_lista_precio): self
    {
        $this->historial_lista_precio = $historial_lista_precio;

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

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    /**
     * @return Collection<int, CuentaCorriente>
     */
    public function getCuentaCorrientes(): Collection
    {
        return $this->cuentaCorrientes;
    }

    public function addCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if (!$this->cuentaCorrientes->contains($cuentaCorriente)) {
            $this->cuentaCorrientes->add($cuentaCorriente);
            $cuentaCorriente->setListaPrecioId($this);
        }

        return $this;
    }

    public function removeCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if ($this->cuentaCorrientes->removeElement($cuentaCorriente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorriente->getListaPrecioId() === $this) {
                $cuentaCorriente->setListaPrecioId(null);
            }
        }

        return $this;
    }

    public function isSocio(): ?bool
    {
        return $this->socio;
    }

    public function setSocio(bool $socio): self
    {
        $this->socio = $socio;

        return $this;
    }

    /**
     * @return Collection<int, ReservaHangar>
     */
    public function getReservasHangar(): Collection
    {
        return $this->reservasHangar;
    }

    public function addReservasHangar(ReservaHangar $reservasHangar): self
    {
        if (!$this->reservasHangar->contains($reservasHangar)) {
            $this->reservasHangar->add($reservasHangar);
            $reservasHangar->setListaPrecio($this);
        }

        return $this;
    }

    public function removeReservasHangar(ReservaHangar $reservasHangar): self
    {
        if ($this->reservasHangar->removeElement($reservasHangar)) {
            // set the owning side to null (unless already changed)
            if ($reservasHangar->getListaPrecio() === $this) {
                $reservasHangar->setListaPrecio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovimientoCuentaVuelo>
     */
    public function getMovimientoCuentaVuelos(): Collection
    {
        return $this->movimientoCuentaVuelos;
    }

    public function addMovimientoCuentaVuelo(MovimientoCuentaVuelo $movimientoCuentaVuelo): self
    {
        if (!$this->movimientoCuentaVuelos->contains($movimientoCuentaVuelo)) {
            $this->movimientoCuentaVuelos->add($movimientoCuentaVuelo);
            $movimientoCuentaVuelo->setListaPrecio($this);
        }

        return $this;
    }

    public function removeMovimientoCuentaVuelo(MovimientoCuentaVuelo $movimientoCuentaVuelo): self
    {
        if ($this->movimientoCuentaVuelos->removeElement($movimientoCuentaVuelo)) {
            // set the owning side to null (unless already changed)
            if ($movimientoCuentaVuelo->getListaPrecio() === $this) {
                $movimientoCuentaVuelo->setListaPrecio(null);
            }
        }

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

    public function isAlumno(): ?bool
    {
        return $this->alumno;
    }

    public function setAlumno(?bool $alumno): self
    {
        $this->alumno = $alumno;

        return $this;
    }

    /**
     * @return Collection<int, Venta>
     */
    public function getVentas(): Collection
    {
        return $this->ventas;
    }

    public function addVenta(Venta $venta): self
    {
        if (!$this->ventas->contains($venta)) {
            $this->ventas->add($venta);
            $venta->setListaPrecio($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): self
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getListaPrecio() === $this) {
                $venta->setListaPrecio(null);
            }
        }

        return $this;
    }

    public function isBautismo(): ?bool
    {
        return $this->bautismo;
    }

    public function setBautismo(bool $bautismo): self
    {
        $this->bautismo = $bautismo;

        return $this;
    }
}
