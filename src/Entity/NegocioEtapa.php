<?php

namespace App\Entity;

use App\Repository\NegocioEtapaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass=NegocioEtapaRepository::class)
 */
class NegocioEtapa
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
    private $descricao;

    /**
     * @ORM\Column(type="integer")
     */
    private $ordem;

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
     * @ORM\OneToMany(targetEntity=Negocio::class, mappedBy="negocioEtapa")
     */
    private $negocios;

    public function __construct()
    {
        $this->negocios = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getOrdem(): ?int
    {
        return $this->ordem;
    }

    public function setOrdem(int $ordem): self
    {
        $this->ordem = $ordem;

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

    /**
     * @return Collection|Negocio[]
     */
    public function getNegocios(): Collection
    {
        return $this->negocios;
    }

    public function addNegocio(Negocio $negocio): self
    {
        if (!$this->negocios->contains($negocio)) {
            $this->negocios[] = $negocio;
            $negocio->setNegocioEtapa($this);
        }

        return $this;
    }

    public function removeNegocio(Negocio $negocio): self
    {
        if ($this->negocios->removeElement($negocio)) {
            // set the owning side to null (unless already changed)
            if ($negocio->getNegocioEtapa() === $this) {
                $negocio->setNegocioEtapa(null);
            }
        }

        return $this;
    }
}
