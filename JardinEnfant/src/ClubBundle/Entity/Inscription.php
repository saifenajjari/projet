<?php

namespace ClubBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Inscription
 *
 * @ORM\Table(name="inscription")
 * @ORM\Entity(repositoryClass="ClubBundle\Repository\InscriptionRepository")
 */
class Inscription
{
    /**

     * @ORM\ManyToOne(targetEntity="Activite")
     * @ORM\JoinColumn(name="activite_id", referencedColumnName="id")
     */
    private $activite;

    /**
     * @return mixed
     */
    public function getActivite()
    {
        return $this->activite;
    }

    /**
     * @param mixed $activite
     */
    public function setActivite($activite)
    {
        $this->activite = $activite;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @return bool
     */
    public function isConfirmed()
    {
        return $this->confirmed;
    }

    /**
     * @param bool $confirmed
     */
    public function setConfirmed($confirmed)
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @var boolean
     *
     * @ORM\Column(name="confirmed", type="boolean" ,options={"default" : false})
     */
    private $confirmed = false;


    /**
     * @var string
     *
     * @ORM\Column(name="NomParent", type="string", length=255)
     */
    private $nomParent;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }



    /**
     * @var string
     *
     * @ORM\Column(name="NomEnfant", type="string", length=255)
     */
    private $nomEnfant;

    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @ORM\Column(name="photo", type="string", length=500)
     */
    private $photo;

    /**
     * @return mixed
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param mixed $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

    /**
     * @var \Date
     *
     * @ORM\Column(name="dated", type="date")
     */
    private $dated;


    /**
     * @var float
     *
     * @ORM\Column(name="montant", type="float")
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="age", type="integer")
     */
    private $age;


    /**
     * @var string
     *
     * @ORM\Column(name="adresse", type="string", length=255)
     */
    private $adresse;

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
    }

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="string", length=255)
     */
    private $commentaire;

    /**
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * @param string $commentaire
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="numTel", type="integer")
     */
    private $numTel;

    /**
     * @return int
     */
    public function getNumTel()
    {
        return $this->numTel;
    }

    /**
     * @param int $numTel
     */
    public function setNumTel($numTel)
    {
        $this->numTel = $numTel;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="nbmois", type="integer")
     */
    private $nbmois;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nomParent
     *
     * @param string $nomParent
     *
     * @return Inscription
     */
    public function setNomParent($nomParent)
    {
        $this->nomParent = $nomParent;

        return $this;
    }

    /**
     * Get nomParent
     *
     * @return string
     */
    public function getNomParent()
    {
        return $this->nomParent;
    }

    /**
     * Set nomEnfant
     *
     * @param string $nomEnfant
     *
     * @return Inscription
     */
    public function setNomEnfant($nomEnfant)
    {
        $this->nomEnfant = $nomEnfant;

        return $this;
    }

    /**
     * Get nomEnfant
     *
     * @return string
     */
    public function getNomEnfant()
    {
        return $this->nomEnfant;
    }

    /**
     * Set dated
     *
     * @param \DateTime $dated
     *
     * @return Inscription
     */
    public function setDated($dated)
    {
        $this->dated = $dated;

        return $this;
    }

    /**
     * Get dated
     *
     * @return \DateTime
     */
    public function getDated()
    {
        return $this->dated;
    }


    /**
     * Set montant
     *
     * @param integer $montant
     *
     * @return Inscription
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return int
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set age
     *
     * @param integer $age
     *
     * @return Inscription
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return int
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set nbmois
     *
     * @param integer $nbmois
     *
     * @return Inscription
     */
    public function setNbmois($nbmois)
    {
        $this->nbmois = $nbmois;

        return $this;
    }

    /**
     * Get nbmois
     *
     * @return int
     */
    public function getNbmois()
    {
        return $this->nbmois;
    }
}

