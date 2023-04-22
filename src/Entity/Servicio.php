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

    #[ORM\OneToMany(mappedBy: 'servicio', targetEntity: ListaPrecio::class)]
    private Collection $listaPrecios;

    #[ORM\OneToMany(mappedBy: 'servicio_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    #[ORM\OneToMany(mappedBy: 'servicio', targetEntity: ReservaHangar::class)]
    private Collection $reservaHangars;

    #[ORM\OneToMany(mappedBy: 'servicio', targetEntity: Mensualidad::class)]
    private Collection $mensualidades;

    #[ORM\Column(nullable: true)]
    private ?bool $es_hangaraje = null;

    #[ORM\Column(nullable: true)]
    private ?bool $defecto = null;

    public function __construct()
    {
        $this->unidadesPagos = new ArrayCollection();
        $this->listaPrecios = new ArrayCollection();
        $this->cuentaCorrientes = new ArrayCollection();
        $this->reservaHangars = new ArrayCollection();
        $this->mensualidades = new ArrayCollection();
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
            $listaPrecio->setServicio($this);
        }

        return $this;
    }

    public function removeListaPrecio(ListaPrecio $listaPrecio): self
    {
        if ($this->listaPrecios->removeElement($listaPrecio)) {
            // set the owning side to null (unless already changed)
            if ($listaPrecio->getServicio() === $this) {
                $listaPrecio->setServicio(null);
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

    /**
     * @return Collection<int, ReservaHangar>
     */
    public function getReservaHangars(): Collection
    {
        return $this->reservaHangars;
    }

    public function addReservaHangar(ReservaHangar $reservaHangar): self
    {
        if (!$this->reservaHangars->contains($reservaHangar)) {
            $this->reservaHangars->add($reservaHangar);
            $reservaHangar->setServicio($this);
        }

        return $this;
    }

    public function removeReservaHangar(ReservaHangar $reservaHangar): self
    {
        if ($this->reservaHangars->removeElement($reservaHangar)) {
            // set the owning side to null (unless already changed)
            if ($reservaHangar->getServicio() === $this) {
                $reservaHangar->setServicio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Mensualidad>
     */
    public function getMensualidades(): Collection
    {
        return $this->mensualidades;
    }

    public function addMensualidade(Mensualidad $mensualidade): self
    {
        if (!$this->mensualidades->contains($mensualidade)) {
            $this->mensualidades->add($mensualidade);
            $mensualidade->setServicio($this);
        }

        return $this;
    }

    public function removeMensualidade(Mensualidad $mensualidade): self
    {
        if ($this->mensualidades->removeElement($mensualidade)) {
            // set the owning side to null (unless already changed)
            if ($mensualidade->getServicio() === $this) {
                $mensualidade->setServicio(null);
            }
        }

        return $this;
    }

    public function isEsHangaraje(): ?bool
    {
        return $this->es_hangaraje;
    }

    public function setEsHangaraje(?bool $es_hangaraje): self
    {
        $this->es_hangaraje = $es_hangaraje;

        return $this;
    }

    public function isDefecto(): ?bool
    {
        return $this->defecto;
    }

    public function setDefecto(?bool $defecto): self
    {
        $this->defecto = $defecto;

        return $this;
    }

}
