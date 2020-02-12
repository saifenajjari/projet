<?php

namespace TransportBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * LigneTransport
 *
 * @ORM\Table(name="ligne_transport")
 * @ORM\Entity(repositoryClass="TransportBundle\Repository\LigneTransportRepository")
 */
class LigneTransport
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
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}

