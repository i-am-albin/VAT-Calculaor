<?php

namespace App\Entity;

use App\Repository\VatMasterRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VatMasterRepository::class)
 */
class VatMaster
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $input_amnt;

    /**
     * @ORM\Column(type="float")
     */
    private $vat_amnt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vat_type;

    /**
     * @ORM\Column(type="float")
     */
    private $vat;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private $created_at;

    /**
     * @ORM\Column(type="float")
     */
    private $net_amount;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $vat_per;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInputAmnt(): ?float
    {
        return $this->input_amnt;
    }

    public function setInputAmntt(float $input_amnt): self
    {
        $this->input_amnt = $input_amnt;

        return $this;
    }

    public function getVatAmnt(): ?float
    {
        return $this->vat_amnt;
    }

    public function setVatAmnt(float $vat_amnt): self
    {
        $this->vat_amnt = $vat_amnt;

        return $this;
    }

    public function getVatType(): ?string
    {
        return $this->vat_type;
    }

    public function setVatType(string $vat_type): self
    {
        $this->vat_type = $vat_type;

        return $this;
    }

    public function getVat(): ?float
    {
        return $this->vat;
    }

    public function setVat(float $vat): self
    {
        $this->vat = $vat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(?\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getNetAmount(): ?float
    {
        return $this->net_amount;
    }

    public function setNetAmount(float $net_amount): self
    {
        $this->net_amount = $net_amount;

        return $this;
    }

    public function getVatPer(): ?string
    {
        return $this->vat_per;
    }

    public function setVatPer(string $vat_per): self
    {
        $this->vat_per = $vat_per;

        return $this;
    }
}
