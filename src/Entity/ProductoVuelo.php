<?php

namespace App\Entity;

use App\Repository\ProductoVueloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoVueloRepository::class)]
class ProductoVuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne(inversedBy: 'productoVuelos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producto $producto = null;

    #[ORM\ManyToOne(inversedBy: 'productoVuelos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vuelo $vuelo = null;

    #[ORM\OneToOne(mappedBy: 'producto_vuelo', cascade: ['persist', 'remove'])]
    private ?MovimientoStock $movimientoStock = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCantidad(): ?int
    {
        return $this->cantidad;
    }

    public function setCantidad(int $cantidad): self
    {
        $this->cantidad = $cantidad;

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

    public function getVuelo(): ?Vuelo
    {
        return $this->vuelo;
    }

    public function setVuelo(?Vuelo $vuelo): self
    {
        $this->vuelo = $vuelo;

        return $this;
    }

    public function getMovimientoStock(): ?MovimientoStock
    {
        return $this->movimientoStock;
    }

    public function setMovimientoStock(?MovimientoStock $movimientoStock): self
    {
        // unset the owning side of the relation if necessary
        if ($movimientoStock === null && $this->movimientoStock !== null) {
            $this->movimientoStock->setProductoVuelo(null);
        }

        // set the owning side of the relation if necessary
        if ($movimientoStock !== null && $movimientoStock->getProductoVuelo() !== $this) {
            $movimientoStock->setProductoVuelo($this);
        }

        $this->movimientoStock = $movimientoStock;

        return $this;
    }
}
