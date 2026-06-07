<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column(length: 255)]
    private ?string $apellido = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Archivo::class)]
    private Collection $archivos;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Participante::class, orphanRemoval: true)]
    private Collection $participaciones;

    #[ORM\OneToMany(mappedBy: 'organizador', targetEntity: Evento::class)]
    private Collection $eventosOrganizados;
    
    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Voto::class)]
    private Collection $votos;
    
    public function __construct()
    {
        $this->archivos = new ArrayCollection();
        $this->participaciones = new ArrayCollection();
        $this->eventosOrganizados = new ArrayCollection();
        $this->votos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

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

    public function setApellido(string $apellido): static
    {
        $this->apellido = $apellido;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    #[\Deprecated]
    public function eraseCredentials(): void
    {
        // @deprecated, to be removed when upgrading to Symfony 8
    }

    /**
     * @return Collection<int, Archivo>
     */
    public function getArchivos(): Collection
    {
        return $this->archivos;
    }

    public function addArchivo(Archivo $archivo): static
    {
        if (!$this->archivos->contains($archivo)) {
            $this->archivos->add($archivo);
            $archivo->setUsuario($this);
        }

        return $this;
    }

    public function removeArchivo(Archivo $archivo): static
    {
        if ($this->archivos->removeElement($archivo)) {
            if ($archivo->getUsuario() === $this) {
                $archivo->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Participante>
     */
    public function getParticipaciones(): Collection
    {
        return $this->participaciones;
    }

    public function addParticipacion(Participante $participacion): static
    {
        if (!$this->participaciones->contains($participacion)) {
            $this->participaciones->add($participacion);
            $participacion->setUsuario($this);
        }

        return $this;
    }

    public function removeParticipacion(Participante $participacion): static
    {
        if ($this->participaciones->removeElement($participacion)) {
            if ($participacion->getUsuario() === $this) {
                $participacion->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Evento>
     */
    public function getEventosOrganizados(): Collection
    {
        return $this->eventosOrganizados;
    }

    public function addEventoOrganizado(Evento $evento): static
    {
        if (!$this->eventosOrganizados->contains($evento)) {
            $this->eventosOrganizados->add($evento);
            $evento->setOrganizador($this);
        }

        return $this;
    }

    public function removeEventoOrganizado(Evento $evento): static
    {
        if ($this->eventosOrganizados->removeElement($evento)) {
            if ($evento->getOrganizador() === $this) {
                $evento->setOrganizador(null);
            }
        }

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
            $voto->setUsuario($this);
        }

        return $this;
    }

    public function removeVoto(Voto $voto): static
    {
        if ($this->votos->removeElement($voto)) {
            if ($voto->getUsuario() === $this) {
                $voto->setUsuario(null);
            }
        }

        return $this;
    }
}
