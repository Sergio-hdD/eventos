<?php

namespace App\Entity;

use App\Repository\VotoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VotoRepository::class)]
#[ORM\Table(name: 'voto')]
#[ORM\UniqueConstraint(
    name: 'uniq_voto_evento_usuario',
    columns: ['evento_id', 'usuario_id']
)]
class Voto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'votos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Evento $evento = null;

    #[ORM\ManyToOne(inversedBy: 'votos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'votos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Candidato $candidato = null;

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

    public function setEvento(?Evento $evento): static
    {
        $this->evento = $evento;

        return $this;
    }

    public function getUsuario(): ?User
    {
        return $this->usuario;
    }

    public function setUsuario(?User $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCandidato(): ?Candidato
    {
        return $this->candidato;
    }

    public function setCandidato(?Candidato $candidato): static
    {
        $this->candidato = $candidato;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}