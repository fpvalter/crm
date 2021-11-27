<?php

namespace App\Entity;

use App\Repository\NotificationRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=NotificationRepository::class)
 */
class Notification
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $userTarget;

    /**
     * @ORM\Column(type="boolean")
     */
    private $displayed;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $scheduledAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $descricao;

    /**
     * @ORM\ManyToOne(targetEntity=Negocio::class, inversedBy="notifications")
     */
    private $negocio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getUserTarget(): ?User
    {
        return $this->userTarget;
    }

    public function setUserTarget(?User $userTarget): self
    {
        $this->userTarget = $userTarget;

        return $this;
    }

    public function getDisplayed(): ?bool
    {
        return $this->displayed;
    }

    public function setDisplayed(bool $displayed): self
    {
        $this->displayed = $displayed;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getScheduledAt(): ?\DateTimeInterface
    {
        return $this->scheduledAt;
    }

    public function setScheduledAt(\DateTimeInterface $scheduledAt): self
    {
        $this->scheduledAt = $scheduledAt;

        return $this;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(?string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getNegocio(): ?Negocio
    {
        return $this->negocio;
    }

    public function setNegocio(?Negocio $negocio): self
    {
        $this->negocio = $negocio;

        return $this;
    }
}
