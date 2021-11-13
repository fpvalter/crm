<?php

namespace App\Entity;

use App\Repository\ContatoRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;

/**
 * @ORM\Entity(repositoryClass=ContatoRepository::class)
 * 
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "patch"},
 *     denormalizationContext={"groups"={"contatoPost"}}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "codigo" : "exact",
 *          "cliente.id" : "exact",
 *          "cliente.cnpj" : "exact",
 *          "cliente.codigo" : "exact"
 *      }
 * )
 */
class Contato
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clienteGet"})
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Cliente::class, inversedBy="contatos", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"clientePost", "contatoPost"})
     */
    private $cliente;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"clientePost", "contatoPost", "clienteGet"})
     */
    private $nome;

    /**
     * @ORM\Column(type="date", nullable=true)
     * @Groups({"clientePost", "contatoPost", "clienteGet"})
     */
    private $dataNascimento;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clientePost", "contatoPost", "clienteGet"})
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     * @Groups({"clientePost", "contatoPost", "clienteGet"})
     */
    private $telefone;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"clientePost", "contatoPost", "clienteGet"})
     */
    private $observacao;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Groups({"clientePost", "contatoPost", "clienteGet"})
     */
    private $codigo;

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

    public function getNome(): ?string
    {
        return $this->nome;
    }

    public function setNome(string $nome): self
    {
        $this->nome = $nome;

        return $this;
    }

    public function getDataNascimento(): ?\DateTimeInterface
    {
        return $this->dataNascimento;
    }

    public function setDataNascimento(?\DateTimeInterface $dataNascimento): self
    {
        $this->dataNascimento = $dataNascimento;

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

    public function getTelefone(): ?string
    {
        return $this->telefone;
    }

    public function setTelefone(?string $telefone): self
    {
        $this->telefone = $telefone;

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

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

        return $this;
    }
}
