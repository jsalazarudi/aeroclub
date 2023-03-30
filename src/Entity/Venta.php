<?php

namespace App\Entity;

use App\Repository\VentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
class Venta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    private ?Socio $socio_id = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    private ?Piloto $piloto_id = null;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    private ?Tesorero $tesorero_id = null;

    #[ORM\OneToMany(mappedBy: 'venta_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    #[ORM\ManyToMany(targetEntity: Producto::class, mappedBy: 'productoVenta')]
    private Collection $productos;

    #[ORM\OneToMany(mappedBy: 'venta_id', targetEntity: ProductoVenta::class)]
    private Collection $productoVentas;

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
        $this->productos = new ArrayCollection();
        $this->productoVentas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(?string $observaciones): self
    {
        $this->observaciones = $observaciones;

        return $this;
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

    public function getSocioId(): ?Socio
    {
        return $this->socio_id;
    }

    public function setSocioId(?Socio $socio_id): self
    {
        $this->socio_id = $socio_id;

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

    public function getTesoreroId(): ?Tesorero
    {
        return $this->tesorero_id;
    }

    public function setTesoreroId(?Tesorero $tesorero_id): self
    {
        $this->tesorero_id = $tesorero_id;

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
            $cuentaCorriente->setVentaId($this);
        }

        return $this;
    }

    public function removeCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if ($this->cuentaCorrientes->removeElement($cuentaCorriente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorriente->getVentaId() === $this) {
                $cuentaCorriente->setVentaId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Producto>
     */
    public function getProductos(): Collection
    {
        return $this->productos;
    }

    public function addProducto(Producto $producto): self
    {
        if (!$this->productos->contains($producto)) {
            $this->productos->add($producto);
            $producto->addProductoVentum($this);
        }

        return $this;
    }

    public function removeProducto(Producto $producto): self
    {
        if ($this->productos->removeElement($producto)) {
            $producto->removeProductoVentum($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductoVenta>
     */
    public function getProductoVentas(): Collection
    {
        return $this->productoVentas;
    }

    public function addProductoVenta(ProductoVenta $productoVenta): self
    {
        if (!$this->productoVentas->contains($productoVenta)) {
            $this->productoVentas->add($productoVenta);
            $productoVenta->setVentaId($this);
        }

        return $this;
    }

    public function removeProductoVenta(ProductoVenta $productoVenta): self
    {
        if ($this->productoVentas->removeElement($productoVenta)) {
            // set the owning side to null (unless already changed)
            if ($productoVenta->getVentaId() === $this) {
                $productoVenta->setVentaId(null);
            }
        }

        return $this;
    }
}
