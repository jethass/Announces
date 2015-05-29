<?php

namespace Annonces\SiteBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Annonces
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Annonces\SiteBundle\Repository\AnnonceRepository")
 */
class Annonce
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
     * @ORM\ManyToOne(targetEntity="Annonces\UtilisateursBundle\Entity\Utilisateur")
     * @ORM\JoinColumn(nullable=false)
     */
     private $utilisateur;

     /**
     * @ORM\ManyToOne(targetEntity="Annonces\SiteBundle\Entity\Categorie",inversedBy="annonces")
     * @ORM\JoinColumn(nullable=false,name="categorie_id", referencedColumnName="id")
     */
     private $categorie;

     /**
     * @ORM\OneToMany(targetEntity="Annonces\SiteBundle\Entity\Media", mappedBy="annonce", cascade={"persist"})
     */
     private $images;


    /**
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=255)
     */
    private $titre;

    /**
     * @var date
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(name="prix", type="float")
     */
    private $prix;

    /**
     * @var boolean
     *
     * @ORM\Column(name="active", type="boolean")
     */
    private $active;

    /**
     * @var telephone
     *
     * @ORM\Column(name="telephone", type="string", nullable=true)
     */
    private $telephone;


     /**
     * @var cp
     *
     * @ORM\Column(name="cp", type="integer", nullable=false)
     */
    private $cp;
 
    /**
     * @var afficheTelephone
     *
     * @ORM\Column(name="affiche_telephone", type="boolean", nullable=true)
     */
    private $afficheTelephone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     *
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Email(
     *     message = "'{{ value }}' n'est pas un email valide."
     * )
     */
    private $email;

 
    public function __toString(){
        return $this->getTitre();
    }

    

    /**
     * Constructor
     */
    public function __construct()
    {
         $this->images = new \Doctrine\Common\Collections\ArrayCollection();
         $this->date = new \DateTime('now');
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
     * Set titre
     *
     * @param string $titre
     * @return Annonce
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get titre
     *
     * @return string 
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     * @return Annonce
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime 
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Annonce
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

    /**
     * Set prix
     *
     * @param float $prix
     * @return Annonce
     */
    public function setPrix($prix)
    {
        $this->prix = $prix;

        return $this;
    }

    /**
     * Get prix
     *
     * @return float 
     */
    public function getPrix()
    {
        return $this->prix;
    }

    /**
     * Set active
     *
     * @param boolean $active
     * @return Annonce
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get active
     *
     * @return boolean 
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     * @return Annonce
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string 
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set cp
     *
     * @param integer $cp
     * @return Annonce
     */
    public function setCp($cp)
    {
        $this->cp = $cp;

        return $this;
    }

    /**
     * Get cp
     *
     * @return integer 
     */
    public function getCp()
    {
        return $this->cp;
    }

    /**
     * Set afficheTelephone
     *
     * @param boolean $afficheTelephone
     * @return Annonce
     */
    public function setAfficheTelephone($afficheTelephone)
    {
        $this->afficheTelephone = $afficheTelephone;

        return $this;
    }

    /**
     * Get afficheTelephone
     *
     * @return boolean 
     */
    public function getAfficheTelephone()
    {
        return $this->afficheTelephone;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Annonce
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set utilisateur
     *
     * @param \Annonces\UtilisateursBundle\Entity\Utilisateur $utilisateur
     * @return Annonce
     */
    public function setUtilisateur(\Annonces\UtilisateursBundle\Entity\Utilisateur $utilisateur)
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    /**
     * Get utilisateur
     *
     * @return \Annonces\UtilisateursBundle\Entity\Utilisateur 
     */
    public function getUtilisateur()
    {
        return $this->utilisateur;
    }

    /**
     * Set categorie
     *
     * @param \Annonces\SiteBundle\Entity\Categorie $categorie
     * @return Annonce
     */
    public function setCategorie(\Annonces\SiteBundle\Entity\Categorie $categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return \Annonces\SiteBundle\Entity\Categorie 
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Add images
     *
     * @param \Annonces\SiteBundle\Entity\Media $images
     * @return Annonce
     */
    public function addImage(\Annonces\SiteBundle\Entity\Media $images)
    {
        $this->images[] = $images;
        $images->setAnnonce($this);
        return $this;
    }

    /**
     * Remove images
     *
     * @param \Annonces\SiteBundle\Entity\Media $images
     */
    public function removeImage(\Annonces\SiteBundle\Entity\Media $images)
    {
        $this->images->removeElement($images);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getImages()
    {
        return $this->images;
    }
}
