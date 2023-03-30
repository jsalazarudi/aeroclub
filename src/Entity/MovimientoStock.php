<?php

namespace App\Entity;

use App\Repository\MovimientoStockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovimientoStockRepository::class)]
class MovimientoStock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $cantidad = null;

    #[ORM\Column(length: 255)]
    private ?string $tipo = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $observaciones = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tesorero $tesorero_id = null;

    #[ORM\ManyToOne(inversedBy: 'movimientoStocks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Producto $producto_id = null;

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

    public function getTesoreroId(): ?Tesorero
    {
        return $this->tesorero_id;
    }

    public function setTesoreroId(?Tesorero $tesorero_id): self
    {
        $this->tesorero_id = $tesorero_id;

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
}
