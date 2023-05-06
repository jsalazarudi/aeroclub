<?php

namespace App\Entity;

use App\Repository\VentaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VentaRepository::class)]
class Venta
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\NotBlank()]
    #[Assert\Type("string")]
    private ?string $observaciones = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\OneToMany(mappedBy: 'venta', targetEntity: ProductoVenta::class,cascade: ['persist'])]
    #[Assert\NotBlank()]
    private Collection $productoVentas;

    #[ORM\ManyToOne(inversedBy: 'ventas')]
    private ?Abono $abono = null;


    #[ORM\ManyToOne(inversedBy: 'ventas')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $realizada = null;

    public function __construct()
    {
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
            $productoVenta->setVenta($this);
        }

        return $this;
    }

    public function removeProductoVenta(ProductoVenta $productoVenta): self
    {
        if ($this->productoVentas->removeElement($productoVenta)) {
            // set the owning side to null (unless already changed)
            if ($productoVenta->getVenta() === $this) {
                $productoVenta->setVenta(null);
            }
        }

        return $this;
    }

    public function getAbono(): ?Abono
    {
        return $this->abono;
    }

    public function setAbono(?Abono $abono): self
    {
        $this->abono = $abono;

        return $this;
    }

    public function __toString(): string
    {
       return $this->observaciones;
    }

    public function getRealizada(): ?Usuario
    {
        return $this->realizada;
    }

    public function setRealizada(?Usuario $realizada): self
    {
        $this->realizada = $realizada;

        return $this;
    }


}
