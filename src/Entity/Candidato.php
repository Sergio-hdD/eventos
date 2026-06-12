<?php

namespace App\Entity;

use App\Repository\CandidatoRepository;
use App\Traits\CamposBasicosTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CandidatoRepository::class)]
class Candidato
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'candidatos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evento $evento = null;

    #[ORM\Column(length: 100)]
    private ?string $nombre = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $apellido = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $foto = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private bool $activo = true;

    #[ORM\Column]
    private int $orden = 0;

    #[ORM\Column]
    private int $cantidadVotos = 0;

    #[ORM\OneToMany(mappedBy: 'candidato', targetEntity: Voto::class, orphanRemoval: true)]
    private Collection $votos;

    use CamposBasicosTrait;

    public function __construct()
    {
        $this->votos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): static
    {
        $this->evento = $evento;

        return $this;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getApellido(): ?string
    {
        return $this->apellido;
    }

    public function setApellido(?string $apellido): static
    {
        $this->apellido = $apellido;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): static
    {
        $this->foto = $foto;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): static
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function isActivo(): bool
    {
        return $this->activo;
    }

    public function setActivo(bool $activo): static
    {
        $this->activo = $activo;

        return $this;
    }

    public function getOrden(): int
    {
        return $this->orden;
    }

    public function setOrden(int $orden): static
    {
        $this->orden = $orden;

        return $this;
    }

    /**
     * @return Collection<int, Voto>
     */
    public function getVotos(): Collection
    {
        return $this->votos;
    }

    public function addVoto(Voto $voto): static
    {
        if (!$this->votos->contains($voto)) {
            $this->votos->add($voto);
            $voto->setCandidato($this);
        }

        return $this;
    }

    public function removeVoto(Voto $voto): static
    {
        if ($this->votos->removeElement($voto)) {
            if ($voto->getCandidato() === $this) {
                $voto->setCandidato(null);
            }
        }

        return $this;
    }

    public function getCantidadVotos(): int
    {
        return $this->cantidadVotos;
    }

    public function setCantidadVotos(int $cantidadVotos): static
    {
        $this->cantidadVotos = $cantidadVotos;

        return $this;
    }

    public function getNombreCompleto(): string
    {
        return trim(sprintf('%s %s', $this->nombre, $this->apellido));
    }

    public function __toString(): string
    {
        return $this->getNombreCompleto();
    }

}