<?php

namespace App\Entity;

use App\Repository\CursoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CursoRepository::class)]
class Curso
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?bool $aprobado = null;

    #[ORM\OneToMany(mappedBy: 'curso_id', targetEntity: Vuelo::class)]
    private Collection $vuelos;

    #[ORM\ManyToOne(inversedBy: 'curso')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Alumno $alumno = null;

    public function __construct()
    {
        $this->vuelos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function isAprobado(): ?bool
    {
        return $this->aprobado;
    }

    public function setAprobado(bool $aprobado): self
    {
        $this->aprobado = $aprobado;

        return $this;
    }

    /**
     * @return Collection<int, Vuelo>
     */
    public function getVuelos(): Collection
    {
        return $this->vuelos;
    }

    public function addVuelo(Vuelo $vuelo): self
    {
        if (!$this->vuelos->contains($vuelo)) {
            $this->vuelos->add($vuelo);
            $vuelo->setCursoId($this);
        }

        return $this;
    }

    public function removeVuelo(Vuelo $vuelo): self
    {
        if ($this->vuelos->removeElement($vuelo)) {
            // set the owning side to null (unless already changed)
            if ($vuelo->getCursoId() === $this) {
                $vuelo->setCursoId(null);
            }
        }

        return $this;
    }

    public function getAlumno(): ?Alumno
    {
        return $this->alumno;
    }

    public function setAlumno(?Alumno $alumno): self
    {
        $this->alumno = $alumno;

        return $this;
    }
}
