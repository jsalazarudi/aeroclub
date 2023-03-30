<?php

namespace App\Entity;

use App\Repository\MovimientoCuentaVueloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MovimientoCuentaVueloRepository::class)]
class MovimientoCuentaVuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $unidades_gastadas = null;

    #[ORM\OneToOne(inversedBy: 'movimientoCuentaVuelo', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vuelo $vuelo_id = null;

    #[ORM\OneToMany(mappedBy: 'movimiento_cuenta_vuelo_id', targetEntity: CuentaCorriente::class)]
    private Collection $cuentaCorrientes;

    public function __construct()
    {
        $this->cuentaCorrientes = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnidadesGastadas(): ?int
    {
        return $this->unidades_gastadas;
    }

    public function setUnidadesGastadas(int $unidades_gastadas): self
    {
        $this->unidades_gastadas = $unidades_gastadas;

        return $this;
    }

    public function getVueloId(): ?Vuelo
    {
        return $this->vuelo_id;
    }

    public function setVueloId(Vuelo $vuelo_id): self
    {
        $this->vuelo_id = $vuelo_id;

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
            $cuentaCorriente->setMovimientoCuentaVueloId($this);
        }

        return $this;
    }

    public function removeCuentaCorriente(CuentaCorriente $cuentaCorriente): self
    {
        if ($this->cuentaCorrientes->removeElement($cuentaCorriente)) {
            // set the owning side to null (unless already changed)
            if ($cuentaCorriente->getMovimientoCuentaVueloId() === $this) {
                $cuentaCorriente->setMovimientoCuentaVueloId(null);
            }
        }

        return $this;
    }
}
