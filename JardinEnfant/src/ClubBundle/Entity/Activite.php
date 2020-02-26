<?php

namespace ClubBundle\Entity;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table(name="activite")
 * @ORM\Entity(repositoryClass="ClubBundle\Repository\ActiviteRepository")
 */
class Activite
{ /**

 * @ORM\ManyToOne(targetEntity="Club")
 * @ORM\JoinColumn(name="club_id", referencedColumnName="id")
 */
    private $club;

    /**
     * @return mixed
     */
    public function getClub()
    {
        return $this->club;
    }

    /**
     * @param mixed $club
     */
    public function setClub($club)
    {
        $this->club = $club;
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
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


    /**
     * @var string
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $photo;

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
    }

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
     * @var int
     *
     * @ORM\Column(name="agemin", type="integer")
     */
    private $agemin;

    /**
     * @var int
     *
     * @ORM\Column(name="agemax", type="integer")
     */
    private $agemax;

    /**
     * @var float
     *
     * @ORM\Column(name="montantp", type="float")
     */
    private $montantp;

    /**
     * @return float
     */
    public function getMontantp()
    {
        return $this->montantp;
    }

    /**
     * @param float $montantp
     */
    public function setMontantp($montantp)
    {
        $this->montantp = $montantp;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="nbDispo", type="integer")
     */
    private $nbDispo;

    /**
     * @return int
     */
    public function getNbDispo()
    {
        return $this->nbDispo;
    }

    /**
     * @param int $nbDispo
     */
    public function setNbDispo($nbDispo)
    {
        $this->nbDispo = $nbDispo;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="jours", type="string", length=255)
     */
    private $jours;

    /**
     * @return string
     */
    public function getJours()
    {
        return $this->jours;
    }

    /**
     * @param string $jours
     */
    public function setJours($jours)
    {
        $this->jours = $jours;
    }



    /**

     *
     * @ORM\Column(name="heured", type="time")
     * @var \DateTime
     */
    private $heured;

    /**
     * @return string
     */
    public function getHeured()
    {
        return $this->heured;
    }

    /**
     * @param string $heured
     */
    public function setHeured($heured)
    {
        $this->heured = $heured;
    }

    /**

     * @ORM\Column(name="heuref", type="time")
     * @var \DateTime
     */
    private $heuref;

    /**
     * @return string
     */
    public function getHeuref()
    {
        return $this->heuref;
    }

    /**
     * @param string $heuref
     */
    public function setHeuref($heuref)
    {
        $this->heuref = $heuref;
    }


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Activite
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set agemin
     *
     * @param integer $agemin
     *
     * @return Activite
     */
    public function setAgemin($agemin)
    {
        $this->agemin = $agemin;

        return $this;
    }

    /**
     * Get agemin
     *
     * @return int
     */
    public function getAgemin()
    {
        return $this->agemin;
    }

    /**
     * Set agemax
     *
     * @param integer $agemax
     *
     * @return Activite
     */
    public function setAgemax($agemax)
    {
        $this->agemax = $agemax;

        return $this;
    }

    /**
     * Get agemax
     *
     * @return int
     */
    public function getAgemax()
    {
        return $this->agemax;
    }

    public  function __toString()
    {
        return(string)($this->getNom());
    }
}

