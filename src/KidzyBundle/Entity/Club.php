<?php

namespace KidzyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Club
 *
 * @ORM\Table(name="Club")
 * @ORM\Entity
 */
class Club
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_club", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClub;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_club", type="string", length=20, nullable=false)
     */
    private $nomClub;

    /**
     * @ORM\Column(type="string",length=255)
     */
    private $descriptionClub;

    /**
     * @return int
     */
    public function getIdClub()
    {
        return $this->idClub;
    }

    /**
     * @param int $idClub
     */
    public function setIdClub($idClub)
    {
        $this->idClub = $idClub;
    }

    /**
     * @return string
     */
    public function getNomClub()
    {
        return $this->nomClub;
    }

    /**
     * @param string $nomClub
     */
    public function setNomClub($nomClub)
    {
        $this->nomClub = $nomClub;
    }

    /**
     * @return mixed
     */
    public function getDescriptionClub()
    {
        return $this->descriptionClub;
    }

    /**
     * @param mixed $descriptionClub
     */
    public function setDescriptionClub($descriptionClub)
    {
        $this->descriptionClub = $descriptionClub;
    }

    /**
     * @return mixed
     */
    public function getAdresseClub()
    {
        return $this->adresseClub;
    }

    /**
     * @param mixed $adresseClub
     */
    public function setAdresseClub($adresseClub)
    {
        $this->adresseClub = $adresseClub;
    }
    /**
     * @ORM\Column(type="string",length=255)
     */
    private $adresseClub;
}