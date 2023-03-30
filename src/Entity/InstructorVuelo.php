<?php

namespace App\Entity;

use App\Repository\InstructorVueloRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: InstructorVueloRepository::class)]
class InstructorVuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $unidades_pagar = null;

    #[ORM\ManyToOne(inversedBy: 'instructorVuelos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Instructor $instructor_id = null;

    #[ORM\ManyToOne(inversedBy: 'instructorVuelos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Vuelo $vuelo_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUnidadesPagar(): ?int
    {
        return $this->unidades_pagar;
    }

    public function setUnidadesPagar(int $unidades_pagar): self
    {
        $this->unidades_pagar = $unidades_pagar;

        return $this;
    }

    public function getInstructorId(): ?Instructor
    {
        return $this->instructor_id;
    }

    public function setInstructorId(?Instructor $instructor_id): self
    {
        $this->instructor_id = $instructor_id;

        return $this;
    }

    public function getVueloId(): ?Vuelo
    {
        return $this->vuelo_id;
    }

    public function setVueloId(?Vuelo $vuelo_id): self
    {
        $this->vuelo_id = $vuelo_id;

        return $this;
    }
}
