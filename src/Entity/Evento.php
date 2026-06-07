<?php

namespace App\Entity;

use App\Repository\EventoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventoRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Evento
{
    public const BORRADOR = 'BORRADOR';
    public const PUBLICADO = 'PUBLICADO';
    public const FINALIZADO = 'FINALIZADO';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $nombre = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $slug = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $descripcion = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $fechaInicio = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $fechaFin = null;

    #[ORM\Column(length: 255, unique: true)]
    private ?string $tokenQr = null;

    #[ORM\Column(length: 20)]
    private string $estado = self::BORRADOR;

    #[ORM\ManyToOne(inversedBy: 'eventosOrganizados')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $organizador = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Archivo::class, orphanRemoval: true)]
    private Collection $archivos;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Participante::class, orphanRemoval: true)]
    private Collection $participantes;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Candidato::class, orphanRemoval: true)]
    private Collection $candidatos;

    #[ORM\OneToMany(mappedBy: 'evento', targetEntity: Voto::class, orphanRemoval: true)]
    private Collection $votos;

    public function __construct()
    {
        $this->archivos = new ArrayCollection();
        $this->participantes = new ArrayCollection();
        $this->candidatos = new ArrayCollection();
        $this->votos = new ArrayCollection();
        $this->tokenQr = bin2hex(random_bytes(16));
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;
        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(?string $descripcion): self
    {
        $this->descripcion = $descripcion;
        return $this;
    }

    public function getFechaInicio(): ?\DateTimeImmutable
    {
        return $this->fechaInicio;
    }

    public function setFechaInicio(\DateTimeImmutable $fechaInicio): self
    {
        $this->fechaInicio = $fechaInicio;
        return $this;
    }

    public function getFechaFin(): ?\DateTimeImmutable
    {
        return $this->fechaFin;
    }

    public function setFechaFin(?\DateTimeImmutable $fechaFin): self
    {
        $this->fechaFin = $fechaFin;
        return $this;
    }

    public function getTokenQr(): ?string
    {
        return $this->tokenQr;
    }

    public function getEstado(): string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;
        return $this;
    }

    public function getOrganizador(): ?User
    {
        return $this->organizador;
    }

    public function setOrganizador(?User $organizador): self
    {
        $this->organizador = $organizador;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    /**
     * @return Collection<int, Archivo>
     */
    public function getArchivos(): Collection
    {
        return $this->archivos;
    }

    /**
     * @return Collection<int, Participante>
     */
    public function getParticipantes(): Collection
    {
        return $this->participantes;
    }

    /**
     * @return Collection<int, Candidato>
     */
    public function getCandidatos(): Collection
    {
        return $this->candidatos;
    }

    /**
     * @return Collection<int, Voto>
     */
    public function getVotos(): Collection
    {
        return $this->votos;
    }

    public function __toString(): string
    {
        return $this->nombre ?? '';
    }
}
