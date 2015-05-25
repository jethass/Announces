<?php

namespace Annonces\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Annonces\SiteBundle\Repository\CategorieRepository")
 */
class Categorie
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Annonces\SiteBundle\Entity\Annonce", mappedBy="categorie", cascade={"persist", "remove"})
     */
    private $annonces;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;


    public function __toString(){
        return $this->getNom();
    }
    
    
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->annonces = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Categorie
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
     * Add annonces
     *
     * @param \Annonces\SiteBundle\Entity\Annonce $annonces
     * @return Categorie
     */
    public function addAnnonce(\Annonces\SiteBundle\Entity\Annonce $annonces)
    {
        $this->annonces[] = $annonces;
        $annonces->setCategorie($this);
        return $this;
    }

    /**
     * Remove annonces
     *
     * @param \Annonces\SiteBundle\Entity\Annonce $annonces
     */
    public function removeAnnonce(\Annonces\SiteBundle\Entity\Annonce $annonces)
    {
        $this->annonces->removeElement($annonces);
    }

    /**
     * Get annonces
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getAnnonces()
    {
        return $this->annonces;
    }
}
