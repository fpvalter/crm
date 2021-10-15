<?php

namespace App\Entity;

use App\Repository\EquipeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EquipeRepository::class)
 */
class Equipe
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nome;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user_gerente;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user_supervisor;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="equipes")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getUserGerente(): ?User
    {
        return $this->user_gerente;
    }

    public function setUserGerente(?User $user_gerente): self
    {
        $this->user_gerente = $user_gerente;

        return $this;
    }

    public function getUserSupervisor(): ?User
    {
        return $this->user_supervisor;
    }

    public function setUserSupervisor(?User $user_supervisor): self
    {
        $this->user_supervisor = $user_supervisor;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }
}
