<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Acteurs
 *
 * @ORM\Table(name="acteur")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\ActeursRepository")
 */

class Acteurs
{
    /**
     * @ORM\ManyToMany(targetEntity="Troiswa\BackBundle\Entity\Films")
     *
     */
    private $liaisonFilms;


    /**
     * @Assert\Image(
     *    maxSize=1000000,
     *    maxSizeMessage="Taille trop importante",
     *    mimeTypes={"image/png","image/jpg","image/jpeg"},
     *    mimeTypesMessage={"Uniquement Images du type png,jpg,jpeg"}
     * )
     */
    private $fichier;

    /**
     * @return mixed
     */
    public function getFichier()
    {
        return $this->fichier;
    }

    /**
     * @param mixed $fichier
     */
    public function setFichier($fichier=null)
    {
        $this->fichier = $fichier;

        return $this;
    }


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @Assert\Length(
     *      min = "1",
     *      max = "150",
     *      minMessage = "Votre Prénom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre Prénom ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @var string
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="prenom", type="string", length=50)
     */
    private $prenom;

    /**
     * @Assert\Length(
     *      min = "1",
     *      max = "150",
     *      minMessage = "Votre Nom doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre Nom ne peut pas être plus long que {{ limit }} caractères"
     * )
     * @var string
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="nom", type="string", length=100)
     */
    private $nom;

    /**
     * @var boolean
     *
     * @Assert\Choice(choices = {"0", "1"}, message = "Choisissez un genre valide.")
     *
     *
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="sexe", type="boolean")
     */
    private $sexe;


    /**
     * @var string
     *
     * @ORM\Column(name="biographie", type="text")
     */
    private $biographie;

    /**
     * Assert date()
     *
     * @var \DateTime
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="dateNaissance", type="date")
     */
    private $dateNaissance;

    /**
     *
     *
     * @var string
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="ville", type="string", length=255)
     */
    private $ville;

    /**
     * @var string
     * @ORM\Column(name="image", type="string", length=255)
     */
    private $image;


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
     * Set prenom
     *
     * @param string $prenom
     * @return Acteurs
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string 
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set nom
     *
     * @param string $nom
     * @return Acteurs
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
     * Set biographie
     *
     * @param string $biographie
     * @return Acteurs
     */
    public function setBiographie($biographie)
    {
        $this->biographie = $biographie;

        return $this;
    }

    /**
     * Get biographie
     *
     * @return string 
     */
    public function getBiographie()
    {
        return $this->biographie;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     * @return Acteurs
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime 
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set ville
     *
     * @param string $ville
     * @return Acteurs
     */
    public function setVille($ville)
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Get ville
     *
     * @return string 
     */
    public function getVille()
    {
        return $this->ville;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Acteurs
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set sexe
     *
     * @param boolean $sexe
     * @return Acteurs
     */
    public function setSexe($sexe)
    {
        $this->sexe = $sexe;

        return $this;
    }

    /**
     * Get sexe
     *
     * @return boolean 
     */
    public function getSexe()
    {
        return $this->sexe;
    }


    public function displayImage()
    {
        //return "images/acteurs/".$this->image;
        return $this->getImageFolder().$this->image;
    }


    private function getImageFolder()   // pour simplifier le chemin (refactoriser le code) ne pas avoir de doublons
    {
        return "images/acteurs/";
    }


    public function upload()    // methode que charge l'image, la déplace et la renome
    {
        if(null===$this->fichier)   //Variable fichier est déclarée en tete de class
        {
            return;
        }
        $monImage=uniqid()."-".$this->fichier->getClientOriginalName();
        //$this->fichier->move(__DIR__."/../../../../web/images/films",$monImage);  //remplacé par lign ci-dessous
        $this->fichier->move(__DIR__."/../../../../web/".$this->getImageFolder(),$monImage);

        $this->image=$monImage;
        $this->fichier=null;
    }


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->liaisonFilms = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add liaisonFilms
     *
     * @param \Troiswa\BackBundle\Entity\Films $liaisonFilms
     * @return Acteurs
     */
    public function addLiaisonFilm(\Troiswa\BackBundle\Entity\Films $liaisonFilms)
    {
        $this->liaisonFilms[] = $liaisonFilms;

        return $this;
    }

    /**
     * Remove liaisonFilms
     *
     * @param \Troiswa\BackBundle\Entity\Films $liaisonFilms
     */
    public function removeLiaisonFilm(\Troiswa\BackBundle\Entity\Films $liaisonFilms)
    {
        $this->liaisonFilms->removeElement($liaisonFilms);
    }

    /**
     * Get liaisonFilms
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getLiaisonFilms()
    {
        return $this->liaisonFilms;
    }



}
