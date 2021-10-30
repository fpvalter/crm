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

/**
 * @ORM\Entity(repositoryClass=ProdutoRepository::class)
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
}
