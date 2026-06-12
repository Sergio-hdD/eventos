<?php

namespace App\Entity;

use App\Repository\ParticipanteRepository;
use App\Traits\CamposBasicosTrait;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ParticipanteRepository::class)]
#[ORM\Table(
    uniqueConstraints: [
        new ORM\UniqueConstraint(
            name: 'uniq_evento_usuario',
            columns: ['evento_id', 'usuario_id']
        )
    ]
)]
class Participante
{
    public const ROL_ORGANIZADOR = 'ORGANIZADOR';
    public const ROL_MODERADOR = 'MODERADOR';
    public const ROL_INVITADO = 'INVITADO';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'participantes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evento $evento = null;

    #[ORM\ManyToOne(inversedBy: 'participaciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\Column(length: 20)]
    private ?string $rol = self::ROL_INVITADO;

    use CamposBasicosTrait;

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

    public function getRol(): ?string
    {
        return $this->rol;
    }

    public function setRol(string $rol): self
    {
        $this->rol = $rol;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function esOrganizador(): bool
    {
        return $this->rol === self::ROL_ORGANIZADOR;
    }

    public function esModerador(): bool
    {
        return $this->rol === self::ROL_MODERADOR;
    }

    public function esInvitado(): bool
    {
        return $this->rol === self::ROL_INVITADO;
    }
}
