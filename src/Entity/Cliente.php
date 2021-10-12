<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 * 
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put"}
 * )
 */
class Cliente
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $codigo_cliente;

    /**
     * @ORM\Column(type="string", length=14)
     */
    private $cnpj;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $razao_social;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $logradouro;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $bairro;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $cep;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telefone1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telefone2;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $telefone3;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $observacao;

    /**
     * @ORM\OneToOne(targetEntity=ClienteInfo::class, mappedBy="cliente", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $clienteInfo;

    /**
     * @ORM\OneToMany(targetEntity=Contato::class, mappedBy="cliente", orphanRemoval=true)
     */
    private $contatos;

    public function __construct()
    {
        $this->contatos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCodigoCliente(): ?string
    {
        return $this->codigo_cliente;
    }

    public function setCodigoCliente(?string $codigo_cliente): self
    {
        $this->codigo_cliente = $codigo_cliente;

        return $this;
    }

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(string $cnpj): self
    {
        $this->cnpj = $cnpj;

        return $this;
    }

    public function getRazaoSocial(): ?string
    {
        return $this->razao_social;
    }

    public function setRazaoSocial(string $razao_social): self
    {
        $this->razao_social = $razao_social;

        return $this;
    }

    public function getLogradouro(): ?string
    {
        return $this->logradouro;
    }

    public function setLogradouro(string $logradouro): self
    {
        $this->logradouro = $logradouro;

        return $this;
    }

    public function getNumero(): ?string
    {
        return $this->numero;
    }

    public function setNumero(string $numero): self
    {
        $this->numero = $numero;

        return $this;
    }

    public function getBairro(): ?string
    {
        return $this->bairro;
    }

    public function setBairro(string $bairro): self
    {
        $this->bairro = $bairro;

        return $this;
    }

    public function getCep(): ?string
    {
        return $this->cep;
    }

    public function setCep(?string $cep): self
    {
        $this->cep = $cep;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelefone1(): ?string
    {
        return $this->telefone1;
    }

    public function setTelefone1(?string $telefone1): self
    {
        $this->telefone1 = $telefone1;

        return $this;
    }

    public function getTelefone2(): ?string
    {
        return $this->telefone2;
    }

    public function setTelefone2(?string $telefone2): self
    {
        $this->telefone2 = $telefone2;

        return $this;
    }

    public function getTelefone3(): ?string
    {
        return $this->telefone3;
    }

    public function setTelefone3(?string $telefone3): self
    {
        $this->telefone3 = $telefone3;

        return $this;
    }

    public function getObservacao(): ?string
    {
        return $this->observacao;
    }

    public function setObservacao(?string $observacao): self
    {
        $this->observacao = $observacao;

        return $this;
    }

    public function getClienteInfo(): ?ClienteInfo
    {
        return $this->clienteInfo;
    }

    public function setClienteInfo(?ClienteInfo $clienteInfo): self
    {
        // unset the owning side of the relation if necessary
        if ($clienteInfo === null && $this->clienteInfo !== null) {
            $this->clienteInfo->setCliente(null);
        }

        // set the owning side of the relation if necessary
        if ($clienteInfo !== null && $clienteInfo->getCliente() !== $this) {
            $clienteInfo->setCliente($this);
        }

        $this->clienteInfo = $clienteInfo;

        return $this;
    }

    /**
     * @return Collection|Contato[]
     */
    public function getContatos(): Collection
    {
        return $this->contatos;
    }

    public function addContato(Contato $contato): self
    {
        if (!$this->contatos->contains($contato)) {
            $this->contatos[] = $contato;
            $contato->setCliente($this);
        }

        return $this;
    }

    public function removeContato(Contato $contato): self
    {
        if ($this->contatos->removeElement($contato)) {
            // set the owning side to null (unless already changed)
            if ($contato->getCliente() === $this) {
                $contato->setCliente(null);
            }
        }

        return $this;
    }
}
