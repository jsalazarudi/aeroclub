<?php

namespace App\Entity;

use App\Repository\ProductoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductoRepository::class)]
class Producto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $descripcion = null;

    #[ORM\OneToMany(mappedBy: 'producto', targetEntity: ListaPrecio::class)]
    private Collection $listaPrecios;

    #[ORM\OneToMany(mappedBy: 'producto_id', targetEntity: MovimientoStock::class)]
    private Collection $movimientoStocks;

    #[ORM\OneToMany(mappedBy: 'producto_id', targetEntity: ProductoVuelo::class)]
    private Collection $productoVuelos;

    #[ORM\OneToMany(mappedBy: 'producto_id', targetEntity: ProductoVenta::class)]
    private Collection $productoVentas;

    #[ORM\Column]
    private ?bool $activo = null;

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
            $listaPrecio->setProducto($this);
        }

        return $this;
    }

    public function removeListaPrecio(ListaPrecio $listaPrecio): self
    {
        if ($this->listaPrecios->removeElement($listaPrecio)) {
            // set the owning side to null (unless already changed)
            if ($listaPrecio->getProducto() === $this) {
                $listaPrecio->setProducto(null);
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
            $movimientoStock->setProducto($this);
        }

        return $this;
    }

    public function removeMovimientoStock(MovimientoStock $movimientoStock): self
    {
        if ($this->movimientoStocks->removeElement($movimientoStock)) {
            // set the owning side to null (unless already changed)
            if ($movimientoStock->getProducto() === $this) {
                $movimientoStock->setProducto(null);
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

    public function isActivo(): ?bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): self
    {
        $this->activo = $activo;

        return $this;
    }

    public function __toString(): string
    {
        return $this->descripcion;
    }


}
