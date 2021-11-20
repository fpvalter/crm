<?php

namespace App\Entity;

use App\Repository\ProdutoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=ProdutoRepository::class)
 * @UniqueEntity(
 *     fields={"codigo"},
 *     repositoryMethod="findByCodigo",
 *     errorPath="codigo",
 *     message="Codigo já cadastrado"
 * )
 * @ApiResource(
 *      collectionOperations={"get", "post"},
 *      itemOperations={"get", "put", "patch"},
 *      denormalizationContext={"groups"={"produtoPost"}}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={"codigo": "exact"}
 * )
 */
class Produto
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"notaFiscalPost"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true, unique=true)
     * @Groups({"produtoPost"})
     */
    private $codigo;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"produtoPost"})
     */
    private $descricao;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"produtoPost"})
     */
    private $categoria;

    /**
     * @ORM\OneToMany(targetEntity=ProdutoEstabelecimento::class, mappedBy="produto", orphanRemoval=true, cascade={"persist", "remove"})
     * @Groups({"produtoPost"})
     */
    private $produtoEstabelecimentos;

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
     * @ORM\ManyToOne(targetEntity=Familia::class, inversedBy="produtos")
     * @Groups({"produtoPost"})
     */
    private $familia;

    /**
     * @ORM\ManyToOne(targetEntity=Subfamilia::class, inversedBy="produtos")
     * @Groups({"produtoPost"})
     */
    private $subfamilia;

    /**
     * @ORM\ManyToOne(targetEntity=Marca::class, inversedBy="produtos")
     * @Groups({"produtoPost"})
     */
    private $marca;

    /**
     * @ORM\ManyToOne(targetEntity=Grupo::class, inversedBy="produtos")
     * @Groups({"produtoPost"})
     */
    private $grupo;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"produtoPost"})
     */
    private $indice;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"produtoPost"})
     */
    private $altura;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"produtoPost"})
     */
    private $aro;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"produtoPost"})
     */
    private $ht;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"produtoPost"})
     */
    private $largura;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     * @Groups({"produtoPost"})
     */
    private $runflat;

    public function __construct()
    {
        $this->produtoEstabelecimentos = new ArrayCollection();
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

    public function getDescricao(): ?string
    {
        return $this->descricao;
    }

    public function setDescricao(string $descricao): self
    {
        $this->descricao = $descricao;

        return $this;
    }

    public function getCategoria(): ?string
    {
        return $this->categoria;
    }

    public function setCategoria(?string $categoria): self
    {
        $this->categoria = $categoria;

        return $this;
    }

    /**
     * @return Collection|ProdutoEstabelecimento[]
     */
    public function getProdutoEstabelecimentos(): Collection
    {
        return $this->produtoEstabelecimentos;
    }

    public function addProdutoEstabelecimento(ProdutoEstabelecimento $produtoEstabelecimento): self
    {
        if (!$this->produtoEstabelecimentos->contains($produtoEstabelecimento)) {
            $this->produtoEstabelecimentos[] = $produtoEstabelecimento;
            $produtoEstabelecimento->setProduto($this);
        }

        return $this;
    }

    public function removeProdutoEstabelecimento(ProdutoEstabelecimento $produtoEstabelecimento): self
    {
        if ($this->produtoEstabelecimentos->removeElement($produtoEstabelecimento)) {
            // set the owning side to null (unless already changed)
            if ($produtoEstabelecimento->getProduto() === $this) {
                $produtoEstabelecimento->setProduto(null);
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

    public function getFamilia(): ?Familia
    {
        return $this->familia;
    }

    public function setFamilia(?Familia $familia): self
    {
        $this->familia = $familia;

        return $this;
    }

    public function getSubfamilia(): ?Subfamilia
    {
        return $this->subfamilia;
    }

    public function setSubfamilia(?Subfamilia $subfamilia): self
    {
        $this->subfamilia = $subfamilia;

        return $this;
    }

    public function getMarca(): ?Marca
    {
        return $this->marca;
    }

    public function setMarca(?Marca $marca): self
    {
        $this->marca = $marca;

        return $this;
    }

    public function getGrupo(): ?Grupo
    {
        return $this->grupo;
    }

    public function setGrupo(?Grupo $grupo): self
    {
        $this->grupo = $grupo;

        return $this;
    }

    public function getIndice(): ?string
    {
        return $this->indice;
    }

    public function setIndice(?string $indice): self
    {
        $this->indice = $indice;

        return $this;
    }

    public function getAltura(): ?string
    {
        return $this->altura;
    }

    public function setAltura(?string $altura): self
    {
        $this->altura = $altura;

        return $this;
    }

    public function getAro(): ?string
    {
        return $this->aro;
    }

    public function setAro(?string $aro): self
    {
        $this->aro = $aro;

        return $this;
    }

    public function getHt(): ?string
    {
        return $this->ht;
    }

    public function setHt(?string $ht): self
    {
        $this->ht = $ht;

        return $this;
    }

    public function getLargura(): ?string
    {
        return $this->largura;
    }

    public function setLargura(?string $largura): self
    {
        $this->largura = $largura;

        return $this;
    }

    public function getRunflat(): ?string
    {
        return $this->runflat;
    }

    public function setRunflat(?string $runflat): self
    {
        $this->runflat = $runflat;

        return $this;
    }
}
