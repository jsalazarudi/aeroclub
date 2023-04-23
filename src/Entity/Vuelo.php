<?php

namespace App\Entity;

use App\Repository\VueloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: VueloRepository::class)]
class Vuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank()]
    #[Assert\Type("string")]
    private ?string $observaciones = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    #[Assert\NotBlank()]
    #[Assert\Type("\DateTimeInterface")]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?bool $es_vuelo_turistico = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    #[Assert\NotBlank()]
    private ?Curso $curso = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    private ?Socio $socio = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    private ?Piloto $piloto = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    #[ORM\JoinColumn(nullable: false)]
    #[Assert\NotBlank()]
    private ?Avion $avion = null;

    #[ORM\OneToMany(mappedBy: 'vuelo_id', targetEntity: InstructorVuelo::class)]
    private Collection $instructorVuelos;

    #[ORM\OneToMany(mappedBy: 'vuelo_id', targetEntity: ProductoVuelo::class)]
    private Collection $productoVuelos;

    #[ORM\OneToOne(mappedBy: 'vuelo', cascade: ['persist', 'remove'])]
    private ?MovimientoCuentaVuelo $movimientoCuentaVuelo = null;

    public function __construct()
    {
        $this->instructorVuelos = new ArrayCollection();
        $this->productoVuelos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObservaciones(): ?string
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones): self
    {
        $this->observaciones = $observaciones;

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

    public function isEsVueloTuristico(): ?bool
    {
        return $this->es_vuelo_turistico;
    }

    public function setEsVueloTuristico(bool $es_vuelo_turistico): self
    {
        $this->es_vuelo_turistico = $es_vuelo_turistico;

        return $this;
    }

    public function getCurso(): ?Curso
    {
        return $this->curso;
    }

    public function setCurso(?Curso $curso): self
    {
        $this->curso = $curso;

        return $this;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

        return $this;
    }

    public function getPiloto(): ?Piloto
    {
        return $this->piloto;
    }

    public function setPiloto(?Piloto $piloto): self
    {
        $this->piloto = $piloto;

        return $this;
    }

    public function getAvion(): ?Avion
    {
        return $this->avion;
    }

    public function setAvion(?Avion $avion): self
    {
        $this->avion = $avion;

        return $this;
    }


    /**
     * @return Collection<int, InstructorVuelo>
     */
    public function getInstructorVuelos(): Collection
    {
        return $this->instructorVuelos;
    }

    public function addInstructorVuelo(InstructorVuelo $instructorVuelo): self
    {
        if (!$this->instructorVuelos->contains($instructorVuelo)) {
            $this->instructorVuelos->add($instructorVuelo);
            $instructorVuelo->setVueloId($this);
        }

        return $this;
    }

    public function removeInstructorVuelo(InstructorVuelo $instructorVuelo): self
    {
        if ($this->instructorVuelos->removeElement($instructorVuelo)) {
            // set the owning side to null (unless already changed)
            if ($instructorVuelo->getVueloId() === $this) {
                $instructorVuelo->setVueloId(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductoVuelo>
     */
    public function getProductoVuelos(): Collection
    {
        return $this->productoVuelos;
    }

    public function addProductoVuelo(ProductoVuelo $productoVuelo): self
    {
        if (!$this->productoVuelos->contains($productoVuelo)) {
            $this->productoVuelos->add($productoVuelo);
            $productoVuelo->setVueloId($this);
        }

        return $this;
    }

    public function removeProductoVuelo(ProductoVuelo $productoVuelo): self
    {
        if ($this->productoVuelos->removeElement($productoVuelo)) {
            // set the owning side to null (unless already changed)
            if ($productoVuelo->getVueloId() === $this) {
                $productoVuelo->setVueloId(null);
            }
        }

        return $this;
    }

    public function getMovimientoCuentaVuelo(): ?MovimientoCuentaVuelo
    {
        return $this->movimientoCuentaVuelo;
    }

    public function setMovimientoCuentaVuelo(MovimientoCuentaVuelo $movimientoCuentaVuelo): self
    {
        // set the owning side of the relation if necessary
        if ($movimientoCuentaVuelo->getVuelo() !== $this) {
            $movimientoCuentaVuelo->setVuelo($this);
        }

        $this->movimientoCuentaVuelo = $movimientoCuentaVuelo;

        return $this;
    }

    public function __toString(): string
    {
        return $this->getFecha()->format('Y-m-d') . ' Avión: ' . $this->getAvion()->getMatricula();
    }
}
