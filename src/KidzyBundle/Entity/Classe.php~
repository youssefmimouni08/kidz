<?php

namespace KidzyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe
 *
 * @ORM\Table(name="classe")
 * @ORM\Entity
 */
class Classe
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id_classe", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idClasse;

    /**
     * @var string
     *
     * @ORM\Column(name="libelle_cla", type="string", length=255, nullable=false)
     */
    private $libelleCla;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;



    /**
     * Get idClasse
     *
     * @return integer
     */
    public function getIdClasse()
    {
        return $this->idClasse;
    }

    /**
     * Set libelleCla
     *
     * @param string $libelleCla
     *
     * @return Classe
     */
    public function setLibelleCla($libelleCla)
    {
        $this->libelleCla = $libelleCla;

        return $this;
    }

    /**
     * Get libelleCla
     *
     * @return string
     */
    public function getLibelleCla()
    {
        return $this->libelleCla;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Classe
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }
}
