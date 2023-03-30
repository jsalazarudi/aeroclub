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
    private ?Producto $producto_id = null;

    #[ORM\ManyToOne(inversedBy: 'productoVentas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Venta $venta_id = null;

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

    public function getProductoId(): ?Producto
    {
        return $this->producto_id;
    }

    public function setProductoId(?Producto $producto_id): self
    {
        $this->producto_id = $producto_id;

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
}
