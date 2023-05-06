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

    #[ORM\OneToMany(mappedBy: 'tesorero', targetEntity: Gasto::class)]
    private Collection $gastos;

    #[ORM\OneToMany(mappedBy: 'tesorero', targetEntity: Nota::class)]
    private Collection $notas;


    #[ORM\OneToOne(mappedBy: 'tesorero', targetEntity: Usuario::class, cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->gastos = new ArrayCollection();
        $this->notas = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $gasto->setTesorero($this);
        }

        return $this;
    }

    public function removeGasto(Gasto $gasto): self
    {
        if ($this->gastos->removeElement($gasto)) {
            // set the owning side to null (unless already changed)
            if ($gasto->getTesorero() === $this) {
                $gasto->setTesorero(null);
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
            $nota->setTesorero($this);
        }

        return $this;
    }

    public function removeNota(Nota $nota): self
    {
        if ($this->notas->removeElement($nota)) {
            // set the owning side to null (unless already changed)
            if ($nota->getTesorero() === $this) {
                $nota->setTesorero(null);
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
