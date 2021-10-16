<?php

namespace App\Entity;

use App\Repository\ClienteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 * 
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "patch"},
 *     denormalizationContext={"groups"={"clientePost"}}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "cnpj": "exact",
 *          "codigo": "exact"
 *      }
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost"})
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=14)
     * @Groups({"clientePost"})
     */
    private $cnpj;

    /**
    * @ORM\Column(type="string", length=255)
    * @Groups({"clientePost"})
    */
    private $razaoSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost"})
     */
    private $logradouro;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"clientePost"})
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"clientePost"})
     */
    private $bairro;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"clientePost"})
     */
    private $cep;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"clientePost"})
     */
    private $telefone1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"clientePost"})
     */
    private $telefone2;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"clientePost"})
     */
    private $telefone3;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"clientePost"})
     */
    private $observacao;

    /**
     * @ORM\OneToOne(targetEntity=ClienteInfo::class, mappedBy="cliente", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"clientePost"})
     */
    private $clienteInfo;

    /**
     * @ORM\OneToMany(targetEntity=Contato::class, mappedBy="cliente", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"clientePost"})
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

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

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
        return $this->razaoSocial;
    }

    public function setRazaoSocial(string $razaoSocial): self
    {
        $this->razaoSocial = $razaoSocial;

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
