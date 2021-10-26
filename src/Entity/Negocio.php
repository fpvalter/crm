<?php

namespace App\Entity;

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

    public function __construct()
    {
        $this->followups = new ArrayCollection();
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
}
