<?php

namespace App\Entity;

use App\Repository\ListaPrecioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ListaPrecioRepository::class)]
class ListaPrecio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $precio = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?HistorialListaPrecio $historial_lista_precio_id = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?Servicio $servicio_id = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?Producto $producto_id = null;

    #[ORM\OneToMany(mappedBy: 'lista_precio_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrecio(): ?int
    {
        return $this->precio;
    }

    public function setPrecio(int $precio): self
    {
        $this->precio = $precio;

        return $this;
    }

    public function getHistorialListaPrecioId(): ?HistorialListaPrecio
    {
        return $this->historial_lista_precio_id;
    }

    public function setHistorialListaPrecioId(?HistorialListaPrecio $historial_lista_precio_id): self
    {
        $this->historial_lista_precio_id = $historial_lista_precio_id;

        return $this;
    }

    public function getServicioId(): ?Servicio
    {
        return $this->servicio_id;
    }

    public function setServicioId(?Servicio $servicio_id): self
    {
        $this->servicio_id = $servicio_id;

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
            $cuentaCorriente->setListaPrecioId($this);
        }

        return $this;
    }

    public function removeCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if ($this->cuentaCorrientes->removeElement($cuentaCorriente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorriente->getListaPrecioId() === $this) {
                $cuentaCorriente->setListaPrecioId(null);
            }
        }

        return $this;
    }
}
