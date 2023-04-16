<?php

namespace App\Entity;

use App\Repository\ListaPrecioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ListaPrecioRepository::class)]
class ListaPrecio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Assert\NotBlank()]
    #[Assert\Type("integer")]
    private ?int $precio = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?HistorialListaPrecio $historial_lista_precio = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?Servicio $servicio = null;

    #[ORM\ManyToOne(inversedBy: 'listaPrecios')]
    private ?Producto $producto = null;

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

    public function getHistorialListaPrecio(): ?HistorialListaPrecio
    {
        return $this->historial_lista_precio;
    }

    public function setHistorialListaPrecioId(?HistorialListaPrecio $historial_lista_precio): self
    {
        $this->historial_lista_precio = $historial_lista_precio;

        return $this;
    }

    public function getServicio(): ?Servicio
    {
        return $this->servicio;
    }

    public function setServicio(?Servicio $servicio): self
    {
        $this->servicio = $servicio;

        return $this;
    }

    public function getProducto(): ?Producto
    {
        return $this->producto;
    }

    public function setProductoId(?Producto $producto): self
    {
        $this->producto = $producto;

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
