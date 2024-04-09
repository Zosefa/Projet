<?php

namespace App\Entity;

use App\Repository\FACTURERepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FACTURERepository::class)]
class FACTURE
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $Qte = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateFacture = null;

    #[ORM\Column]
    private ?float $FraisLivraison = null;

    #[ORM\Column]
    private ?float $MontantTotal = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Commande $Commande = null;

    #[ORM\ManyToOne(inversedBy: 'factures')]
    private ?ModePaiement $ModePaiement = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateLivraison = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQte(): ?int
    {
        return $this->Qte;
    }

    public function setQte(int $Qte): static
    {
        $this->Qte = $Qte;

        return $this;
    }

    public function getDateFacture(): ?\DateTimeInterface
    {
        return $this->DateFacture;
    }

    public function setDateFacture(\DateTimeInterface $DateFacture): static
    {
        $this->DateFacture = $DateFacture;

        return $this;
    }

    public function getFraisLivraison(): ?float
    {
        return $this->FraisLivraison;
    }

    public function setFraisLivraison(float $FraisLivraison): static
    {
        $this->FraisLivraison = $FraisLivraison;

        return $this;
    }

    public function getMontantTotal(): ?float
    {
        return $this->MontantTotal;
    }

    public function setMontantTotal(float $MontantTotal): static
    {
        $this->MontantTotal = $MontantTotal;

        return $this;
    }

    public function getCommande(): ?Commande
    {
        return $this->Commande;
    }

    public function setCommande(?Commande $Commande): static
    {
        $this->Commande = $Commande;

        return $this;
    }

    public function getModePaiement(): ?ModePaiement
    {
        return $this->ModePaiement;
    }

    public function setModePaiement(?ModePaiement $ModePaiement): static
    {
        $this->ModePaiement = $ModePaiement;

        return $this;
    }

    public function getDateLivraison(): ?\DateTimeInterface
    {
        return $this->DateLivraison;
    }

    public function setDateLivraison(\DateTimeInterface $DateLivraison): static
    {
        $this->DateLivraison = $DateLivraison;

        return $this;
    }

}
