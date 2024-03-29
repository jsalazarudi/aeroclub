<?php

namespace App\Entity;

use App\Repository\MovimientoStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MovimientoStockRepository::class)]
class MovimientoStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type('integer')]
    private ?int $cantidad = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Type('string')]
    private ?string $observaciones = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private ?Producto $producto = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $realizado = null;

    #[ORM\OneToOne(inversedBy: 'movimientoStock', cascade: ['persist', 'remove'])]
    private ?ProductoVenta $producto_venta = null;

    #[ORM\OneToOne(inversedBy: 'movimientoStock', cascade: ['persist', 'remove'])]
    private ?ProductoVuelo $producto_vuelo = null;

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

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
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

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProducto(?Producto $producto): self
    {
        $this->producto = $producto;

        return $this;
    }

    public function getRealizado(): ?Usuario
    {
        return $this->realizado;
    }

    public function setRealizado(?Usuario $realizado): self
    {
        $this->realizado = $realizado;

        return $this;
    }

    public function getProductoVenta(): ?ProductoVenta
    {
        return $this->producto_venta;
    }

    public function setProductoVenta(?ProductoVenta $producto_venta): self
    {
        $this->producto_venta = $producto_venta;

        return $this;
    }

    public function getProductoVuelo(): ?ProductoVuelo
    {
        return $this->producto_vuelo;
    }

    public function setProductoVuelo(?ProductoVuelo $producto_vuelo): self
    {
        $this->producto_vuelo = $producto_vuelo;

        return $this;
    }
}
