<?php

namespace App\Entity;

use App\Repository\ServicioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ServicioRepository::class)]
#[UniqueEntity('codigo')]
class Servicio
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank()]
    #[Assert\Type("string")]
    private ?string $codigo = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type("string")]
    private ?string $descripcion = null;

    #[ORM\OneToMany(mappedBy: 'servicio', targetEntity: UnidadesPago::class)]
    private Collection $unidadesPagos;

    #[ORM\OneToMany(mappedBy: 'servicio_id', targetEntity: ListaPrecio::class)]
    private Collection $listaPrecios;

    #[ORM\OneToMany(mappedBy: 'servicio_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    public function __construct()
    {
        $this->unidadesPagos = new ArrayCollection();
        $this->listaPrecios = new ArrayCollection();
        $this->cuentaCorrientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    /**
     * @return Collection<int, UnidadesPago>
     */
    public function getUnidadesPagos(): Collection
    {
        return $this->unidadesPagos;
    }

    public function addUnidadesPago(UnidadesPago $unidadesPago): self
    {
        if (!$this->unidadesPagos->contains($unidadesPago)) {
            $this->unidadesPagos->add($unidadesPago);
            $unidadesPago->setServicio($this);
        }

        return $this;
    }

    public function removeUnidadesPago(UnidadesPago $unidadesPago): self
    {
        if ($this->unidadesPagos->removeElement($unidadesPago)) {
            // set the owning side to null (unless already changed)
            if ($unidadesPago->getServicio() === $this) {
                $unidadesPago->setServicio(null);
            }
        }

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
            $listaPrecio->setServicioId($this);
        }

        return $this;
    }

    public function removeListaPrecio(ListaPrecio $listaPrecio): self
    {
        if ($this->listaPrecios->removeElement($listaPrecio)) {
            // set the owning side to null (unless already changed)
            if ($listaPrecio->getServicioId() === $this) {
                $listaPrecio->setServicioId(null);
            }
        }

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
            $cuentaCorriente->setServicioId($this);
        }

        return $this;
    }

    public function removeCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if ($this->cuentaCorrientes->removeElement($cuentaCorriente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorriente->getServicioId() === $this) {
                $cuentaCorriente->setServicioId(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->descripcion;
    }

}
