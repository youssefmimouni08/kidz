<?php

namespace KidzyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Garde
 *
 * @ORM\Table(name="garde", indexes={@ORM\Index(name="fk_id_enffantt", columns={"id_enfant"})})
 * @ORM\Entity
 */
class Garde
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_garde", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idGarde;

    /**
     * @var string
     *
     * @ORM\Column(name="activite_garde", type="string", length=255, nullable=false)
     */
    private $activiteGarde;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_garde", type="float", precision=10, scale=0, nullable=false)
     */
    private $prixGarde;

    /**
     * @var string
     *
     * @ORM\Column(name="duree_garde", type="string", length=50, nullable=false)
     */
    private $dureeGarde;

    /**
     * @var \Enfant
     *
     * @ORM\ManyToOne(targetEntity="Enfant")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_enfant", referencedColumnName="id_enfant")
     * })
     */
    private $idEnfant;



    /**
     * Get idGarde
     *
     * @return integer
     */
    public function getIdGarde()
    {
        return $this->idGarde;
    }

    /**
     * Set activiteGarde
     *
     * @param string $activiteGarde
     *
     * @return Garde
     */
    public function setActiviteGarde($activiteGarde)
    {
        $this->activiteGarde = $activiteGarde;

        return $this;
    }

    /**
     * Get activiteGarde
     *
     * @return string
     */
    public function getActiviteGarde()
    {
        return $this->activiteGarde;
    }

    /**
     * Set prixGarde
     *
     * @param float $prixGarde
     *
     * @return Garde
     */
    public function setPrixGarde($prixGarde)
    {
        $this->prixGarde = $prixGarde;

        return $this;
    }

    /**
     * Get prixGarde
     *
     * @return float
     */
    public function getPrixGarde()
    {
        return $this->prixGarde;
    }

    /**
     * Set dureeGarde
     *
     * @param string $dureeGarde
     *
     * @return Garde
     */
    public function setDureeGarde($dureeGarde)
    {
        $this->dureeGarde = $dureeGarde;

        return $this;
    }

    /**
     * Get dureeGarde
     *
     * @return string
     */
    public function getDureeGarde()
    {
        return $this->dureeGarde;
    }

    /**
     * Set idEnfant
     *
     * @param \KidzyBundle\Entity\Enfant $idEnfant
     *
     * @return Garde
     */
    public function setIdEnfant(\KidzyBundle\Entity\Enfant $idEnfant = null)
    {
        $this->idEnfant = $idEnfant;

        return $this;
    }

    /**
     * Get idEnfant
     *
     * @return \KidzyBundle\Entity\Enfant
     */
    public function getIdEnfant()
    {
        return $this->idEnfant;
    }
}
