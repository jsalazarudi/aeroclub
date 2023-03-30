<?php

namespace App\Entity;

use App\Repository\VueloRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VueloRepository::class)]
class Vuelo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $observaciones = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha = null;

    #[ORM\Column]
    private ?bool $es_vuelo_turistico = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    private ?Curso $curso_id = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    private ?Socio $socio_id = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    private ?Piloto $piloto_id = null;

    #[ORM\ManyToOne(inversedBy: 'vuelos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Avion $avion_id = null;

    #[ORM\OneToOne(mappedBy: 'vuelo_id', cascade: ['persist', 'remove'])]
    private ?MovimientoCuentaVuelo $movimientoCuentaVuelo = null;

    #[ORM\OneToMany(mappedBy: 'vuelo_id', targetEntity: InstructorVuelo::class)]
    private Collection $instructorVuelos;

    #[ORM\OneToMany(mappedBy: 'vuelo_id', targetEntity: ProductoVuelo::class)]
    private Collection $productoVuelos;

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

    public function getCursoId(): ?Curso
    {
        return $this->curso_id;
    }

    public function setCursoId(?Curso $curso_id): self
    {
        $this->curso_id = $curso_id;

        return $this;
    }

    public function getSocioId(): ?Socio
    {
        return $this->socio_id;
    }

    public function setSocioId(?Socio $socio_id): self
    {
        $this->socio_id = $socio_id;

        return $this;
    }

    public function getPilotoId(): ?Piloto
    {
        return $this->piloto_id;
    }

    public function setPilotoId(?Piloto $piloto_id): self
    {
        $this->piloto_id = $piloto_id;

        return $this;
    }

    public function getAvionId(): ?Avion
    {
        return $this->avion_id;
    }

    public function setAvionId(?Avion $avion_id): self
    {
        $this->avion_id = $avion_id;

        return $this;
    }

    public function getMovimientoCuentaVuelo(): ?MovimientoCuentaVuelo
    {
        return $this->movimientoCuentaVuelo;
    }

    public function setMovimientoCuentaVuelo(MovimientoCuentaVuelo $movimientoCuentaVuelo): self
    {
        // set the owning side of the relation if necessary
        if ($movimientoCuentaVuelo->getVueloId() !== $this) {
            $movimientoCuentaVuelo->setVueloId($this);
        }

        $this->movimientoCuentaVuelo = $movimientoCuentaVuelo;

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
}
