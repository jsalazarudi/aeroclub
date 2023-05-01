<?php

namespace App\Entity;

use App\Repository\InstructorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: InstructorRepository::class)]
class Instructor
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(mappedBy: 'habilitado_por_instructor', targetEntity: Alumno::class)]
    private Collection $alumnos;


    #[ORM\OneToOne(mappedBy: 'instructor', targetEntity: Usuario::class, cascade: ['persist', 'remove'])]
    #[Assert\Type(type: Usuario::class)]
    #[Assert\Valid]
    private ?Usuario $usuario = null;

    public function __construct()
    {
        $this->alumnos = new ArrayCollection();
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
            $alumno->setHabilitadoPorInstructor($this);
        }

        return $this;
    }

    public function removeAlumno(Alumno $alumno): self
    {
        if ($this->alumnos->removeElement($alumno)) {
            // set the owning side to null (unless already changed)
            if ($alumno->getHabilitadoPorInstructor() === $this) {
                $alumno->setHabilitadoPorInstructor(null);
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
            $this->usuario->setInstructor(null);
        }

        // set the owning side of the relation if necessary
        if ($usuario !== null && $usuario->getInstructor() !== $this) {
            $usuario->setInstructor($this);
        }

        $this->usuario = $usuario;

        return $this;
    }

}
