<?php

namespace KidzyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Event
 *
 * @ORM\Table(name="event")
 * @ORM\Entity
 */
class Event
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_event", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="nom_event", type="string", length=20, nullable=false)
     */
    private $nomEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="date_event", type="string", length=255, nullable=false)
     */
    private $dateEvent;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_event", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="descr_event", type="string", length=600, nullable=false)
     */
    private $descrEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="type_event", type="string", length=600, nullable=false)
     */
    private $typeEvent;

    /**
     * @var string
     *
     * @ORM\Column(name="lieu_event", type="string", length=500, nullable=false)
     */
    private $lieuEvent;



    /**
     * Get idEvent
     *
     * @return integer
     */
    public function getIdEvent()
    {
        return $this->idEvent;
    }

    /**
     * Set nomEvent
     *
     * @param string $nomEvent
     *
     * @return Event
     */
    public function setNomEvent($nomEvent)
    {
        $this->nomEvent = $nomEvent;

        return $this;
    }

    /**
     * Get nomEvent
     *
     * @return string
     */
    public function getNomEvent()
    {
        return $this->nomEvent;
    }

    /**
     * Set dateEvent
     *
     * @param string $dateEvent
     *
     * @return Event
     */
    public function setDateEvent($dateEvent)
    {
        $this->dateEvent = $dateEvent;

        return $this;
    }

    /**
     * Get dateEvent
     *
     * @return string
     */
    public function getDateEvent()
    {
        return $this->dateEvent;
    }

    /**
     * Set prixEvent
     *
     * @param float $prixEvent
     *
     * @return Event
     */
    public function setPrixEvent($prixEvent)
    {
        $this->prixEvent = $prixEvent;

        return $this;
    }

    /**
     * Get prixEvent
     *
     * @return float
     */
    public function getPrixEvent()
    {
        return $this->prixEvent;
    }

    /**
     * Set descrEvent
     *
     * @param string $descrEvent
     *
     * @return Event
     */
    public function setDescrEvent($descrEvent)
    {
        $this->descrEvent = $descrEvent;

        return $this;
    }

    /**
     * Get descrEvent
     *
     * @return string
     */
    public function getDescrEvent()
    {
        return $this->descrEvent;
    }

    /**
     * Set typeEvent
     *
     * @param string $typeEvent
     *
     * @return Event
     */
    public function setTypeEvent($typeEvent)
    {
        $this->typeEvent = $typeEvent;

        return $this;
    }

    /**
     * Get typeEvent
     *
     * @return string
     */
    public function getTypeEvent()
    {
        return $this->typeEvent;
    }

    /**
     * Set lieuEvent
     *
     * @param string $lieuEvent
     *
     * @return Event
     */
    public function setLieuEvent($lieuEvent)
    {
        $this->lieuEvent = $lieuEvent;

        return $this;
    }

    /**
     * Get lieuEvent
     *
     * @return string
     */
    public function getLieuEvent()
    {
        return $this->lieuEvent;
    }
}
