<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column(length: 255)]
    private ?string $estado = null;

    #[ORM\OneToMany(mappedBy: 'producto_id', targetEntity: ListaPrecio::class)]
    private Collection $listaPrecios;

    #[ORM\OneToMany(mappedBy: 'producto_id', targetEntity: MovimientoStock::class)]
    private Collection $movimientoStocks;

    #[ORM\OneToMany(mappedBy: 'producto_id', targetEntity: ProductoVuelo::class)]
    private Collection $productoVuelos;

    #[ORM\OneToMany(mappedBy: 'producto_id', targetEntity: ProductoVenta::class)]
    private Collection $productoVentas;

    public function __construct()
    {
        $this->listaPrecios = new ArrayCollection();
        $this->movimientoStocks = new ArrayCollection();
        $this->productoVuelos = new ArrayCollection();
        $this->productoVentas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    /**
     * @return Collection<int, ListaPrecio>
     */
    public function getListaPrecios(): Collection
    {
        return $this->listaPrecios;
    }

    public function addListaPrecio(ListaPrecio $listaPrecio): self
    {
        if (!$this->listaPrecios->contains($listaPrecio)) {
            $this->listaPrecios->add($listaPrecio);
            $listaPrecio->setProductoId($this);
        }

        return $this;
    }

    public function removeListaPrecio(ListaPrecio $listaPrecio): self
    {
        if ($this->listaPrecios->removeElement($listaPrecio)) {
            // set the owning side to null (unless already changed)
            if ($listaPrecio->getProductoId() === $this) {
                $listaPrecio->setProductoId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovimientoStock>
     */
    public function getMovimientoStocks(): Collection
    {
        return $this->movimientoStocks;
    }

    public function addMovimientoStock(MovimientoStock $movimientoStock): self
    {
        if (!$this->movimientoStocks->contains($movimientoStock)) {
            $this->movimientoStocks->add($movimientoStock);
            $movimientoStock->setProductoId($this);
        }

        return $this;
    }

    public function removeMovimientoStock(MovimientoStock $movimientoStock): self
    {
        if ($this->movimientoStocks->removeElement($movimientoStock)) {
            // set the owning side to null (unless already changed)
            if ($movimientoStock->getProductoId() === $this) {
                $movimientoStock->setProductoId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductoVuelo>
     */
    public function getProductoVuelos(): Collection
    {
        return $this->productoVuelos;
    }

    public function addProductoVuelo(ProductoVuelo $productoVuelo): self
    {
        if (!$this->productoVuelos->contains($productoVuelo)) {
            $this->productoVuelos->add($productoVuelo);
            $productoVuelo->setProductoId($this);
        }

        return $this;
    }

    public function removeProductoVuelo(ProductoVuelo $productoVuelo): self
    {
        if ($this->productoVuelos->removeElement($productoVuelo)) {
            // set the owning side to null (unless already changed)
            if ($productoVuelo->getProductoId() === $this) {
                $productoVuelo->setProductoId(null);
            }
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
            $productoVenta->setProductoId($this);
        }

        return $this;
    }

    public function removeProductoVenta(ProductoVenta $productoVenta): self
    {
        if ($this->productoVentas->removeElement($productoVenta)) {
            // set the owning side to null (unless already changed)
            if ($productoVenta->getProductoId() === $this) {
                $productoVenta->setProductoId(null);
            }
        }

        return $this;
    }
}
