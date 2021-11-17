<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\TransportadoraRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ApiResource(
 *     collectionOperations={"get", "post"},
 *     itemOperations={"get", "put", "patch"},
 *     denormalizationContext={"groups"={"transportadoraPost"}},
 *     normalizationContext={"groups"={"transportadoraGet"}}
 * )
 * @ApiFilter(
 *      SearchFilter::class, 
 *      properties={
 *          "codigo": "exact"
 *      }
 * )
 * @ORM\Entity(repositoryClass=TransportadoraRepository::class)
 */
class Transportadora
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"clientePost", "clienteGet"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"clienteGet", "transportadoraPost", "transportadoraGet"})
     */
    private $razaoSocial;

    /**
     * @ORM\Column(type="string", length=14, nullable=true)
     * @Groups({"clienteGet", "transportadoraPost", "transportadoraGet"})
     */
    private $cnpj;

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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Groups({"clienteGet", "transportadoraPost", "transportadoraGet"})
     */
    private $codigo;

    /**
     * @ORM\ManyToOne(targetEntity=Cidade::class, inversedBy="transportadoras")
     * @Groups({"transportadoraPost", "transportadoraGet", "clienteGet"})
     */
    private $cidade;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getCnpj(): ?string
    {
        return $this->cnpj;
    }

    public function setCnpj(?string $cnpj): self
    {
        $this->cnpj = $cnpj;

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

    public function getCodigo(): ?string
    {
        return $this->codigo;
    }

    public function setCodigo(?string $codigo): self
    {
        $this->codigo = $codigo;

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
}
