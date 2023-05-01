<?php

namespace App\Entity;

use App\Repository\ProductoVentaRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductoVentaRepository::class)]
class ProductoVenta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\ManyToOne(inversedBy: 'productoVentas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producto $producto = null;

    #[ORM\ManyToOne(inversedBy: 'productoVentas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Venta $venta = null;

    #[ORM\ManyToOne(inversedBy: 'productoVentas')]
    private ?ListaPrecio $lista_precio = null;

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

    public function getVenta(): ?Venta
    {
        return $this->venta;
    }

    public function setVenta(?Venta $venta): self
    {
        $this->venta = $venta;

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
}
