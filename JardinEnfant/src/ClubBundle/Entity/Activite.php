<?php

namespace ClubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Activite
 *
 * @ORM\Table(name="activite")
 * @ORM\Entity(repositoryClass="ClubBundle\Repository\ActiviteRepository")
 */
class Activite
{
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
     * @var \DateTime
     *
     * @ORM\Column(name="dated", type="time")
     */
    private $dated;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="datef", type="time")
     */
    private $datef;


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

    /**
     * Set dated
     *
     * @param \DateTime $dated
     *
     * @return Activite
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
     * Set datef
     *
     * @param \DateTime $datef
     *
     * @return Activite
     */
    public function setDatef($datef)
    {
        $this->datef = $datef;

        return $this;
    }

    /**
     * Get datef
     *
     * @return \DateTime
     */
    public function getDatef()
    {
        return $this->datef;
    }
}

