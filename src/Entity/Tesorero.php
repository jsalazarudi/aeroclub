<?php

namespace App\Entity;

use App\Repository\TesoreroRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: TesoreroRepository::class)]
class Tesorero
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\OneToMany(mappedBy: 'habilitado_por_tesorero_id', targetEntity: Alumno::class)]
    private Collection $alumnos;

    #[ORM\OneToMany(mappedBy: 'tesorero_id', targetEntity: Abono::class)]
    private Collection $abonos;

    #[ORM\OneToMany(mappedBy: 'tesorero_id', targetEntity: Venta::class)]
    private Collection $ventas;

    #[ORM\OneToMany(mappedBy: 'tesorero_id', targetEntity: MovimientoStock::class)]
    private Collection $movimientoStocks;

    #[ORM\OneToMany(mappedBy: 'tesorero_id', targetEntity: Gasto::class)]
    private Collection $gastos;

    #[ORM\OneToMany(mappedBy: 'tesorero_id', targetEntity: Nota::class)]
    private Collection $notas;


    #[ORM\OneToOne(targetEntity: Usuario::class, mappedBy: 'tesorero', cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
        $this->abonos = new ArrayCollection();
        $this->ventas = new ArrayCollection();
        $this->movimientoStocks = new ArrayCollection();
        $this->gastos = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Alumno>
     */
    public function getAlumnos(): Collection
    {
        return $this->alumnos;
    }

    public function addAlumno(Alumno $alumno): self
    {
        if (!$this->alumnos->contains($alumno)) {
            $this->alumnos->add($alumno);
            $alumno->setHabilitadoPorTesoreroId($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getHabilitadoPorTesoreroId() === $this) {
                $alumno->setHabilitadoPorTesoreroId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Abono>
     */
    public function getAbonos(): Collection
    {
        return $this->abonos;
    }

    public function addAbono(Abono $abono): self
    {
        if (!$this->abonos->contains($abono)) {
            $this->abonos->add($abono);
            $abono->setTesoreroId($this);
        }

        return $this;
    }

    public function removeAbono(Abono $abono): self
    {
        if ($this->abonos->removeElement($abono)) {
            // set the owning side to null (unless already changed)
            if ($abono->getTesoreroId() === $this) {
                $abono->setTesoreroId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Venta>
     */
    public function getVentas(): Collection
    {
        return $this->ventas;
    }

    public function addVenta(Venta $venta): self
    {
        if (!$this->ventas->contains($venta)) {
            $this->ventas->add($venta);
            $venta->setTesoreroId($this);
        }

        return $this;
    }

    public function removeVenta(Venta $venta): self
    {
        if ($this->ventas->removeElement($venta)) {
            // set the owning side to null (unless already changed)
            if ($venta->getTesoreroId() === $this) {
                $venta->setTesoreroId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, MovimientoStock>
     */
    public function getMovimientoStocks(): Collection
    {
        return $this->movimientoStocks;
    }

    public function addMovimientoStock(MovimientoStock $movimientoStock): self
    {
        if (!$this->movimientoStocks->contains($movimientoStock)) {
            $this->movimientoStocks->add($movimientoStock);
            $movimientoStock->setTesoreroId($this);
        }

        return $this;
    }

    public function removeMovimientoStock(MovimientoStock $movimientoStock): self
    {
        if ($this->movimientoStocks->removeElement($movimientoStock)) {
            // set the owning side to null (unless already changed)
            if ($movimientoStock->getTesoreroId() === $this) {
                $movimientoStock->setTesoreroId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Gasto>
     */
    public function getGastos(): Collection
    {
        return $this->gastos;
    }

    public function addGasto(Gasto $gasto): self
    {
        if (!$this->gastos->contains($gasto)) {
            $this->gastos->add($gasto);
            $gasto->setTesoreroId($this);
        }

        return $this;
    }

    public function removeGasto(Gasto $gasto): self
    {
        if ($this->gastos->removeElement($gasto)) {
            // set the owning side to null (unless already changed)
            if ($gasto->getTesoreroId() === $this) {
                $gasto->setTesoreroId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Nota>
     */
    public function getNotas(): Collection
    {
        return $this->notas;
    }

    public function addNota(Nota $nota): self
    {
        if (!$this->notas->contains($nota)) {
            $this->notas->add($nota);
            $nota->setTesoreroId($this);
        }

        return $this;
    }

    public function removeNota(Nota $nota): self
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getTesoreroId() === $this) {
                $nota->setTesoreroId(null);
            }
        }

        return $this;
    }

    public function __toString(): string
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): self
    {
        // unset the owning side of the relation if necessary
        if ($usuario === null && $this->usuario !== null) {
            $this->usuario->setTesorero(null);
        }

        // set the owning side of the relation if necessary
        if ($usuario !== null && $usuario->getTesorero() !== $this) {
            $usuario->setTesorero($this);
        }

        $this->usuario = $usuario;

        return $this;
    }


}
