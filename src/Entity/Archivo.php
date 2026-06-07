<?php

namespace App\Entity;

use App\Repository\ArchivoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ArchivoRepository::class)]
class Archivo
{
    public const TIPO_IMAGEN = 'imagen';
    public const TIPO_VIDEO = 'video';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'archivos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evento $evento = null;

    #[ORM\ManyToOne(inversedBy: 'archivos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreOriginal = null;

    #[ORM\Column(length: 255)]
    private ?string $nombreFisico = null;

    #[ORM\Column(length: 255)]
    private ?string $ruta = null;

    #[ORM\Column(length: 100)]
    private ?string $mimeType = null;

    #[ORM\Column(length: 20)]
    private ?string $extension = null;

    #[ORM\Column]
    private ?int $tamano = null;

    #[ORM\Column(length: 20)]
    private ?string $tipo = null;

    #[ORM\Column(nullable: true)]
    private ?int $ancho = null;

    #[ORM\Column(nullable: true)]
    private ?int $alto = null;

    #[ORM\Column(nullable: true)]
    private ?int $duracion = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEvento(): ?Evento
    {
        return $this->evento;
    }

    public function setEvento(?Evento $evento): self
    {
        $this->evento = $evento;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getNombreOriginal(): ?string
    {
        return $this->nombreOriginal;
    }

    public function setNombreOriginal(string $nombreOriginal): self
    {
        $this->nombreOriginal = $nombreOriginal;

        return $this;
    }

    public function getNombreFisico(): ?string
    {
        return $this->nombreFisico;
    }

    public function setNombreFisico(string $nombreFisico): self
    {
        $this->nombreFisico = $nombreFisico;

        return $this;
    }

    public function getRuta(): ?string
    {
        return $this->ruta;
    }

    public function setRuta(string $ruta): self
    {
        $this->ruta = $ruta;

        return $this;
    }

    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    public function setMimeType(string $mimeType): self
    {
        $this->mimeType = $mimeType;

        return $this;
    }

    public function getExtension(): ?string
    {
        return $this->extension;
    }

    public function setExtension(string $extension): self
    {
        $this->extension = $extension;

        return $this;
    }

    public function getTamano(): ?int
    {
        return $this->tamano;
    }

    public function setTamano(int $tamano): self
    {
        $this->tamano = $tamano;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        if (!in_array($tipo, [self::TIPO_IMAGEN, self::TIPO_VIDEO])) {
            throw new \InvalidArgumentException('Tipo inválido');
        }

        $this->tipo = $tipo;

        return $this;
    }

    public function getAncho(): ?int
    {
        return $this->ancho;
    }

    public function setAncho(?int $ancho): self
    {
        $this->ancho = $ancho;

        return $this;
    }

    public function getAlto(): ?int
    {
        return $this->alto;
    }

    public function setAlto(?int $alto): self
    {
        $this->alto = $alto;

        return $this;
    }

    public function getDuracion(): ?int
    {
        return $this->duracion;
    }

    public function setDuracion(?int $duracion): self
    {
        $this->duracion = $duracion;

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

    public function esImagen(): bool
    {
        return $this->tipo === self::TIPO_IMAGEN;
    }

    public function esVideo(): bool
    {
        return $this->tipo === self::TIPO_VIDEO;
    }
}