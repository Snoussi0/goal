<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\Utilisateur;
/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client 
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateNaissance;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $photo;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $sexe;


    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Utilisateur", mappedBy="client", cascade={"persist", "remove"})
     */
    private $utilisateur;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Reservation", mappedBy="Client", cascade={"persist", "remove"})
     */
    private $reservation;



    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

   

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    

    
    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        // set (or unset) the owning side of the relation if necessary
        $newClient = $utilisateur === null ? null : $this;
        if ($newClient !== $utilisateur->getClient()) {
            $utilisateur->setClient($newClient);
        }

        return $this;
    }


    public function __toString()
    {
        return $this->prenom;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(Reservation $reservation): self
    {
        $this->reservation = $reservation;

        // set the owning side of the relation if necessary
        if ($this !== $reservation->getClient()) {
            $reservation->setClient($this);
        }

        return $this;
    }
}
