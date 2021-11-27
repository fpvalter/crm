<?php

namespace App\Entity;

use App\Enum\NegocioStatus;
use App\Repository\NegocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=NegocioRepository::class)
 */
class Negocio
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class, inversedBy="negocios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $cliente;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $titulo;

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
     * @ORM\ManyToOne(targetEntity=NegocioEtapa::class, inversedBy="negocios")
     */
    private $negocioEtapa;

    /**
     * @ORM\OneToMany(targetEntity=Followup::class, mappedBy="negocio")
     */
    private $followups;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=Contato::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $contato;

    /**
     * @ORM\OneToMany(targetEntity=Notification::class, mappedBy="negocio")
     */
    private $notifications;

    public function __construct()
    {
        $this->followups = new ArrayCollection();
        $this->notifications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCliente(): ?Cliente
    {
        return $this->cliente;
    }

    public function setCliente(?Cliente $cliente): self
    {
        $this->cliente = $cliente;

        return $this;
    }

    public function getTitulo(): ?string
    {
        return $this->titulo;
    }

    public function setTitulo(?string $titulo): self
    {
        $this->titulo = $titulo;

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

    public function getNegocioEtapa(): ?NegocioEtapa
    {
        return $this->negocioEtapa;
    }

    public function setNegocioEtapa(?NegocioEtapa $negocioEtapa): self
    {
        $this->negocioEtapa = $negocioEtapa;

        return $this;
    }

    /**
     * @return Collection|Followup[]
     */
    public function getFollowups(): Collection
    {
        return $this->followups;
    }

    public function addFollowup(Followup $followup): self
    {
        if (!$this->followups->contains($followup)) {
            $this->followups[] = $followup;
            $followup->setNegocio($this);
        }

        return $this;
    }

    public function removeFollowup(Followup $followup): self
    {
        if ($this->followups->removeElement($followup)) {
            // set the owning side to null (unless already changed)
            if ($followup->getNegocio() === $this) {
                $followup->setNegocio(null);
            }
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {

        if ($status && !in_array($status, NegocioStatus::$choices)) {
            throw new \InvalidArgumentException("Status inválido! [" . implode(",", NegocioStatus::$choices) . "]");
        }

        $this->status = $status;

        return $this;
    }

    public function getContato(): ?Contato
    {
        return $this->contato;
    }

    public function setContato(?Contato $contato): self
    {
        $this->contato = $contato;

        return $this;
    }

    /**
     * @return Collection|Notification[]
     */
    public function getNotifications(): Collection
    {
        return $this->notifications;
    }

    public function addNotification(Notification $notification): self
    {
        if (!$this->notifications->contains($notification)) {
            $this->notifications[] = $notification;
            $notification->setNegocio($this);
        }

        return $this;
    }

    public function removeNotification(Notification $notification): self
    {
        if ($this->notifications->removeElement($notification)) {
            // set the owning side to null (unless already changed)
            if ($notification->getNegocio() === $this) {
                $notification->setNegocio(null);
            }
        }

        return $this;
    }
}
