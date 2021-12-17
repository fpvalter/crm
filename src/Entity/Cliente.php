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
use App\Enum\ClienteTipoCompra;
use App\Enum\TipoPessoa;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 * @ORM\Entity(repositoryClass=ClienteRepository::class)
 * @UniqueEntity(
 *     fields={"cnpj"},
 *     repositoryMethod="findByCnpj",
 *     errorPath="cnpj",
 *     message="CNPJ já cadastrado"
 * )
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "patch"},
 *     denormalizationContext={"groups"={"clientePost"}},
 *     normalizationContext={"groups"={"clienteGet"}}
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
     * @Groups({"notaFiscalPost", "contatoPost", "clienteGet", "clienteInfoPost"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=14, unique=true)
     * @Groups({"clientePost", "clienteGet"})
     * @NotBlank(message="CNPJ obrigatorio")
     */
    private $cnpj;

    /**
    * @ORM\Column(type="string", length=255)
    * @Groups({"clientePost", "clienteGet"})
    */
    private $razaoSocial;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $logradouro;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $numero;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $bairro;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $cep;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $telefone1;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $telefone2;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $telefone3;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $observacao;

    /**
     * @ORM\OneToOne(targetEntity=ClienteInfo::class, mappedBy="cliente", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $clienteInfo;

    /**
     * @ORM\OneToMany(targetEntity=Contato::class, mappedBy="cliente", cascade={"persist", "remove"}, orphanRemoval=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $contatos;

    /**
     * @ORM\ManyToOne(targetEntity=Seguimento::class, inversedBy="clientes")
     * @Groups({"clientePost", "clienteGet"})
     */
    private $seguimento;

    /**
     * @ORM\OneToMany(targetEntity=Followup::class, mappedBy="cliente", orphanRemoval=true)
     */
    private $followups;

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
     * @ORM\OneToMany(targetEntity=Negocio::class, mappedBy="cliente")
     */
    private $negocios;

    /**
     * @ORM\OneToMany(targetEntity=NotaFiscal::class, mappedBy="cliente")
     */
    private $notaFiscals;

    /**
     * @ORM\ManyToOne(targetEntity=Vendedor::class, inversedBy="clientes")
     * @Groups({"clientePost", "clienteGet"})
     */
    private $vendedor;

    /**
     * @ORM\Column(type="simple_array", nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $tipoCompra = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $nomeFantasia;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $complemento;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $site;

    /**
     * @ORM\Column(type="string", length=1, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $tipoPessoa;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $emailNfe;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $emailFinanceiro;

    /**
     * @ORM\ManyToOne(targetEntity=Cidade::class, inversedBy="clientes")
     * @Groups({"clientePost", "clienteGet"})
     */
    private $cidade;

    /**
     * @ORM\ManyToOne(targetEntity=Transportadora::class)
     * @Groups({"clientePost", "clienteGet"})
     */
    private $transportadora;

    public function __construct()
    {
        $this->contatos = new ArrayCollection();
        $this->followups = new ArrayCollection();
        $this->negocios = new ArrayCollection();
        $this->notaFiscals = new ArrayCollection();
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

    public function getSeguimento(): ?Seguimento
    {
        return $this->seguimento;
    }

    public function setSeguimento(?Seguimento $seguimento): self
    {
        $this->seguimento = $seguimento;

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
            $followup->setCliente($this);
        }

        return $this;
    }

    public function removeFollowup(Followup $followup): self
    {
        if ($this->followups->removeElement($followup)) {
            // set the owning side to null (unless already changed)
            if ($followup->getCliente() === $this) {
                $followup->setCliente(null);
            }
        }

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
            $negocio->setCliente($this);
        }

        return $this;
    }

    public function removeNegocio(Negocio $negocio): self
    {
        if ($this->negocios->removeElement($negocio)) {
            // set the owning side to null (unless already changed)
            if ($negocio->getCliente() === $this) {
                $negocio->setCliente(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|NotaFiscal[]
     */
    public function getNotaFiscals(): Collection
    {
        return $this->notaFiscals;
    }

    public function addNotaFiscal(NotaFiscal $notaFiscal): self
    {
        if (!$this->notaFiscals->contains($notaFiscal)) {
            $this->notaFiscals[] = $notaFiscal;
            $notaFiscal->setCliente($this);
        }

        return $this;
    }

    public function removeNotaFiscal(NotaFiscal $notaFiscal): self
    {
        if ($this->notaFiscals->removeElement($notaFiscal)) {
            // set the owning side to null (unless already changed)
            if ($notaFiscal->getCliente() === $this) {
                $notaFiscal->setCliente(null);
            }
        }

        return $this;
    }   

    public function getVendedor(): ?Vendedor
    {
        return $this->vendedor;
    }

    public function setVendedor(?Vendedor $vendedor): self
    {
        $this->vendedor = $vendedor;

        return $this;
    }

    public function getTipoCompra(): ?array
    {
        return $this->tipoCompra;
    }

    public function setTipoCompra(?array $tipoCompra): self
    {

        foreach($tipoCompra as $tipo) {
            if (!in_array($tipo, ClienteTipoCompra::$choices)) {
                throw new \InvalidArgumentException("Tipo compra invalido! [" . implode(",", ClienteTipoCompra::$choices) . "]");
            }
        }

        $this->tipoCompra = $tipoCompra;

        return $this;
    }

    public function getNomeFantasia(): ?string
    {
        return $this->nomeFantasia;
    }

    public function setNomeFantasia(?string $nomeFantasia): self
    {
        $this->nomeFantasia = $nomeFantasia;

        return $this;
    }

    public function getComplemento(): ?string
    {
        return $this->complemento;
    }

    public function setComplemento(?string $complemento): self
    {
        $this->complemento = $complemento;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getTipoPessoa(): ?string
    {
        return $this->tipoPessoa;
    }

    public function setTipoPessoa(?string $tipoPessoa): self
    {

        if ($tipoPessoa && !in_array($tipoPessoa, TipoPessoa::$choices)) {
            throw new \InvalidArgumentException("Tipo Pessoa Inválido! [" . implode(",", TipoPessoa::$choices) . "]");
        }

        $this->tipoPessoa = $tipoPessoa;

        return $this;
    }

    public function getEmailNfe(): ?string
    {
        return $this->emailNfe;
    }

    public function setEmailNfe(?string $emailNfe): self
    {
        $this->emailNfe = $emailNfe;

        return $this;
    }

    public function getEmailFinanceiro(): ?string
    {
        return $this->emailFinanceiro;
    }

    public function setEmailFinanceiro(?string $emailFinanceiro): self
    {
        $this->emailFinanceiro = $emailFinanceiro;

        return $this;
    }

    public function getCidade(): ?Cidade
    {
        return $this->cidade;
    }

    public function setCidade(?Cidade $cidade): self
    {
        $this->cidade = $cidade;

        return $this;
    }

    public function getTransportadora(): ?Transportadora
    {
        return $this->transportadora;
    }

    public function setTransportadora(?Transportadora $transportadora): self
    {
        $this->transportadora = $transportadora;

        return $this;
    }
}
