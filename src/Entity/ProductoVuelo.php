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
    private ?Producto $producto_id = null;

    #[ORM\ManyToOne(inversedBy: 'productoVuelos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vuelo $vuelo_id = null;

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

    public function getVueloId(): ?Vuelo
    {
        return $this->vuelo_id;
    }

    public function setVueloId(?Vuelo $vuelo_id): self
    {
        $this->vuelo_id = $vuelo_id;

        return $this;
    }
}
