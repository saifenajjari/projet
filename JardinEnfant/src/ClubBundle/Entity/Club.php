<?php

namespace ClubBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Club
 *
 * @ORM\Table(name="club")
 * @ORM\Entity(repositoryClass="ClubBundle\Repository\ClubRepository")
 */
class Club
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
     * @var string
     *
     * @ORM\Column(name="jardin", type="string", length=255)
     */
    private $jardin;



    /**
     * @return string
     */
    public function getJardin()
    {
        return $this->jardin;
    }

    /**
     * @param string $jardin
     */
    public function setJardin($jardin)
    {
        $this->jardin = $jardin;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="descp", type="string", length=255)
     */
    private $descp;

    /**
     * @var int
     *
     * @ORM\Column(name="nbAct", type="integer" ,options={"default" : 0})
     */
    private $nbAct = 0;

    /**
     * @return int
     */
    public function getNbAct()
    {
        return $this->nbAct;
    }

    /**
     * @param int $nbAct
     */
    public function setNbAct($nbAct)
    {
        $this->nbAct = $nbAct;
    }


    /**
     * @var string
     *
     * @ORM\Column(name="contact", type="string", length=255)
     */
    private $contact ;

    /**
     * @return string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @param string $contact
     */
    public function setContact($contact)
    {
        $this->contact = $contact;
    }


    /**
     *
     * @Assert\File(mimeTypes={ "image/png", "image/jpeg" })
     * @ORM\Column(name="image", type="string", length=500)
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
     * @return Club
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
     * Set descp
     *
     * @param string $descp
     *
     * @return Club
     */
    public function setDescp($descp)
    {
        $this->descp = $descp;

        return $this;
    }

    /**
     * Get descp
     *
     * @return string
     */
    public function getDescp()
    {
        return $this->descp;
    }
}

