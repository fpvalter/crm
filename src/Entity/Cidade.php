<?php

namespace App\Entity;

use App\Repository\CidadeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CidadeRepository::class)
 */
class Cidade
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $codigoIbge;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $municipio;

    /**
     * @ORM\Column(type="string", length=2, nullable=true)
     */
    private $uf;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $estado;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $regiao;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $mesorregiao;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $microrregiao;

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
}
