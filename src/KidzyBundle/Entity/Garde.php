<?php

namespace KidzyBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Garde
 *
 * @ORM\Table(name="garde")
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
     * @ORM\Column(name="nom_garde", type="string", length=255, nullable=true)
     *  @Assert\Length(
     *      min = 5,
     *      max = 30,
     *      minMessage = "Le Titre doit contenir au moins {{ limit }} caractéres ",
     *      maxMessage = "Le Titre doit contenir au plus {{ limit }} caractéres "
     * )
     * @Assert\NotBlank
     */
    private $nomGarde;

    /**
     * @var float
     *
     * @ORM\Column(name="prix_garde", type="float", precision=10, scale=0, nullable=false)
     *  @Assert\NotBlank
     */
    private $prixGarde;

    /**
     * @var string
     *
     * @ORM\Column(name="duree_garde", type="string", length=50, nullable=false)
     *  @Assert\NotBlank
     */
    private $dureeGarde;

    /**
     * @var string
     *
     * @ORM\Column(name="description_garde", type="string", length=255, nullable=false)
     *
     * @Assert\Length(
     *      min = 5,
     *      max = 30,
     *      minMessage = "Le Titre doit contenir au moins {{ limit }} caractéres ",
     *      maxMessage = "Le Titre doit contenir au plus {{ limit }} caractéres "
     * )
     * @Assert\NotBlank
     */
    private $descriptionGarde;

    /**
     * @ORM\OneToMany(targetEntity="Enfant", mappedBy="idGarde")
     */
    private $enfants;



    /**
     * @return mixed
     */
    public function getEnfants()
    {
        return $this->enfants;
    }

    /**
     * @param mixed $enfants
     */
    public function setEnfants($enfants)
    {
        $this->enfants = $enfants;
    }


    /**
     * @return int
     */
    public function getIdGarde()
    {
        return $this->idGarde;
    }

    /**
     * @param int $idGarde
     */
    public function setIdGarde($idGarde)
    {
        $this->idGarde = $idGarde;
    }

    /**
     * @return string
     */
    public function getNomGarde()
    {
        return $this->nomGarde;
    }

    /**
     * @param string $nomGarde
     */
    public function setNomGarde($nomGarde)
    {
        $this->nomGarde = $nomGarde;
    }

    /**
     * @return float
     */
    public function getPrixGarde()
    {
        return $this->prixGarde;
    }

    /**
     * @param float $prixGarde
     */
    public function setPrixGarde($prixGarde)
    {
        $this->prixGarde = $prixGarde;
    }

    /**
     * @return string
     */
    public function getDureeGarde()
    {
        return $this->dureeGarde;
    }

    /**
     * @param string $dureeGarde
     */
    public function setDureeGarde($dureeGarde)
    {
        $this->dureeGarde = $dureeGarde;
    }

    /**
     * @return string
     */
    public function getDescriptionGarde()
    {
        return $this->descriptionGarde;
    }

    /**
     * @param string $descriptionGarde
     */
    public function setDescriptionGarde($descriptionGarde)
    {
        $this->descriptionGarde = $descriptionGarde;
    }

    /**
     * Add enfant
     *
     * @param \KidzyBundle\Entity\Enfant $enfant
     *
     * @return Garde
     */
    public function addEnfant(\KidzyBundle\Entity\Enfant $enfant)
    {
        $this->enfant[] = $enfant;

        return $this;
    }

    /**
     * Remove enfant
     *
     * @param \KidzyBundle\Entity\Enfant $enfant
     */
    public function removeEnfant(\KidzyBundle\Entity\Enfant $enfant)
    {
        $this->enfant->removeElement($enfant);
    }

    /**
     * Get enfant
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEnfant()
    {
        return $this->enfant;
    }



}
