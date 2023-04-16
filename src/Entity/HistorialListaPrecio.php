<?php

namespace App\Entity;

use App\Repository\HistorialListaPrecioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HistorialListaPrecioRepository::class)]
class HistorialListaPrecio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $porcentaje_cambio = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\OneToMany(mappedBy: 'historial_lista_precio', targetEntity: ListaPrecio::class)]
    private Collection $listaPrecios;

    public function __construct()
    {
        $this->listaPrecios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPorcentajeCambio(): ?int
    {
        return $this->porcentaje_cambio;
    }

    public function setPorcentajeCambio(int $porcentaje_cambio): self
    {
        $this->porcentaje_cambio = $porcentaje_cambio;

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
            $listaPrecio->setHistorialListaPrecio($this);
        }

        return $this;
    }

    public function removeListaPrecio(ListaPrecio $listaPrecio): self
    {
        if ($this->listaPrecios->removeElement($listaPrecio)) {
            // set the owning side to null (unless already changed)
            if ($listaPrecio->getHistorialListaPrecio() === $this) {
                $listaPrecio->setHistorialListaPrecio(null);
            }
        }

        return $this;
    }
}
