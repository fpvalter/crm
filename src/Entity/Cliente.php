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
use Gedmo\Mapping\Annotation as Gedmo;

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
     * @Groups({"notaFiscalPost"})
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

    /**
     * @ORM\ManyToOne(targetEntity=Seguimento::class, inversedBy="clientes")
     */
    private $seguimento;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="clientes")
     */
    private $users;

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

    public function __construct()
    {
        $this->contatos = new ArrayCollection();
        $this->users = new ArrayCollection();
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
}
