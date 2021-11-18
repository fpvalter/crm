<?php

namespace App\Entity;

use App\Repository\CidadeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ApiResource(
 *     collectionOperations={"get"},
 *     itemOperations={"get"},
 *     denormalizationContext={"groups"={"cidadePost"}}
 * )
 * @ORM\Entity(repositoryClass=CidadeRepository::class)
 */
class Cidade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clientePost", "clienteGet", "transportadoraPost", "transportadoraGet"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"clienteGet", "transportadoraGet", "cidadePost"})
     */
    private $codigoIbge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clienteGet", "transportadoraGet", "cidadePost"})
     */
    private $municipio;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     * @Groups({"clienteGet", "transportadoraGet", "cidadePost"})
     */
    private $uf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clienteGet", "transportadoraGet", "cidadePost"})
     */
    private $estado;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"clienteGet", "transportadoraGet", "cidadePost"})
     */
    private $regiao;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"clienteGet", "transportadoraGet", "cidadePost"})
     */
    private $mesorregiao;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"clienteGet", "transportadoraGet", "cidadePost"})
     */
    private $microrregiao;

    /**
     * @ORM\OneToMany(targetEntity=Cliente::class, mappedBy="cidade")
     */
    private $clientes;

    /**
     * @ORM\OneToMany(targetEntity=Transportadora::class, mappedBy="cidade")
     */
    private $transportadoras;

    public function __construct()
    {
        $this->clientes = new ArrayCollection();
        $this->transportadoras = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->municipio . "-" . $this->uf;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoIbge(): ?string
    {
        return $this->codigoIbge;
    }

    public function setCodigoIbge(string $codigoIbge): self
    {
        $this->codigoIbge = $codigoIbge;

        return $this;
    }

    public function getMunicipio(): ?string
    {
        return $this->municipio;
    }

    public function setMunicipio(?string $municipio): self
    {
        $this->municipio = $municipio;

        return $this;
    }

    public function getUf(): ?string
    {
        return $this->uf;
    }

    public function setUf(?string $uf): self
    {
        $this->uf = $uf;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(?string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getRegiao(): ?string
    {
        return $this->regiao;
    }

    public function setRegiao(?string $regiao): self
    {
        $this->regiao = $regiao;

        return $this;
    }

    public function getMesorregiao(): ?string
    {
        return $this->mesorregiao;
    }

    public function setMesorregiao(?string $mesorregiao): self
    {
        $this->mesorregiao = $mesorregiao;

        return $this;
    }

    public function getMicrorregiao(): ?string
    {
        return $this->microrregiao;
    }

    public function setMicrorregiao(?string $microrregiao): self
    {
        $this->microrregiao = $microrregiao;

        return $this;
    }

    /**
     * @return Collection|Cliente[]
     */
    public function getClientes(): Collection
    {
        return $this->clientes;
    }

    public function addCliente(Cliente $cliente): self
    {
        if (!$this->clientes->contains($cliente)) {
            $this->clientes[] = $cliente;
            $cliente->setCidade($this);
        }

        return $this;
    }

    public function removeCliente(Cliente $cliente): self
    {
        if ($this->clientes->removeElement($cliente)) {
            // set the owning side to null (unless already changed)
            if ($cliente->getCidade() === $this) {
                $cliente->setCidade(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Cliente[]
     */
    public function getTransportadoras(): Collection
    {
        return $this->transportadoras;
    }

    public function addTransportadora(Transportadora $transportadora): self
    {
        if (!$this->clientes->contains($transportadora)) {
            $this->transportadoras[] = $transportadora;
            $transportadora->setCidade($this);
        }

        return $this;
    }

    public function removeTransportadora(Transportadora $transportadora): self
    {
        if ($this->clientes->removeElement($transportadora)) {
            // set the owning side to null (unless already changed)
            if ($transportadora->getCidade() === $this) {
                $transportadora->setCidade(null);
            }
        }

        return $this;
    }
}
