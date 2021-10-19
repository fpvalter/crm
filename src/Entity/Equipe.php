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
    private $userGerente;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $userSupervisor;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="equipes")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->nome;
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
        return $this->userGerente;
    }

    public function setUserGerente(?User $userGerente): self
    {
        $this->userGerente = $userGerente;

        return $this;
    }

    public function getUserSupervisor(): ?User
    {
        return $this->userSupervisor;
    }

    public function setUserSupervisor(?User $userSupervisor): self
    {
        $this->userSupervisor = $userSupervisor;

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
