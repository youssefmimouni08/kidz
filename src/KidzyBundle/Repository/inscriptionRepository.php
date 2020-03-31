<?php


namespace KidzyBundle\Repository;


use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Doctrine\Tests\OrmFunctionalTestCase;

class inscriptionRepository extends EntityRepository
{
    public function myfinfDomaine($idClub)
    {$qb=$this->getEntityManager()->createQuery("select  c.nomEnfant , c.prenomEnfant, i.idInscrit,c.idEnfant , p.idClub from KidzyBundle:Inscription i JOIN i.idEnfant c JOIN i.idClub p where i.idClub=:id")
        ->setParameter('id', $idClub);
        return $query=$qb->getResult();
    }

    public function myfinfDomaines($idInscrit)
    {
        $qb = $this->getEntityManager()->createQuery("select  c.nomEnfant , c.prenomEnfant, i.idInscrit,c.idEnfant , p.idClub from KidzyBundle:Inscription i JOIN i.idEnfant c JOIN i.idClub p where  i.idInscrit=:idInscrit")

            ->setParameter('idInscrit', $idInscrit);

        return $query = $qb->getResult();

    }
    public function myfinfInsc($idEnfant,$idClub)
    {
        $qb = $this->getEntityManager()->createQuery("select  i from KidzyBundle:Inscription i  where  i.idEnfant=:idEnfant and i.idClub=:idClub ")

            ->setParameter('idEnfant', $idEnfant)
        ->setParameter('idClub', $idClub);

        return $query = $qb->getResult();

    }
    public function myfinfClub($idParent)
    {
        $qb = $this->getEntityManager()->createQuery("select  c.nomClub , c.descriptionClub,c.adresseClub from KidzyBundle:Inscription i JOIN i.idEnfant e JOIN i.idClub c where  e.idParent<>:idParent")

            ->setParameter('idParent', $idParent);

        return $query = $qb->getResult();

    }
    public function myfinfnbre($idClub)
    {
        $qb = $this->getEntityManager()->createQuery("select count(i.idEnfant) from KidzyBundle:Inscription i where  i.idClub=:idClub")

            ->setParameter('idClub', $idClub);

        return $query = $qb->getQuery()->getSingleScalarResult();



    }
}