<?php

namespace Troiswa\BackBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Films
 *
 * @ORM\Table(name="film")
 * @ORM\Entity(repositoryClass="Troiswa\BackBundle\Entity\FilmsRepository")
 */

class Films
{
    /**
     * @Assert\Image(
     *    maxSize=1000000,
     *    maxSizeMessage="Taille trop importante",
     *    mimeTypes={"image/png","image/jpg","image/jpeg"},
     *    mimeTypesMessage={"Uniquement Images du type png,jpg,jpeg"}
     * )
     */
     private $fichier;   // on genere les getters et setters

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
    public function setFichier($fichier)
    {
        $this->fichier = $fichier;
        return $fichier;
    }



    /**
     * @ORM\ManyToOne(targetEntity="Troiswa\BackBundle\Entity\Genres")
     */
    private $genre;


    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * * @Assert\Length(
     *      min = "1",
     *      max = "150",
     *      minMessage = "Votre Titre doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre Titre ne peut pas être plus long que {{ limit }} caractères"
     * )
     *      *
     * @var string
     *
     * @ORM\Column(name="titre", type="string", length=150)
     */
    private $titre;

    /**
     * @Assert\Length(
     *      min = "2",
     *      max = "300",
     *      minMessage = "Votre description doit faire au moins {{ limit }} caractères",
     *      maxMessage = "Votre description ne peut pas être plus long que {{ limit }} caractères"
     * )
     *
     * @var string
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var \DateTime
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="dateDeRealisation", type="datetime")
     */
    private $dateDeRealisation;

    /**
     * @var float
     * @Assert\NotBlank(message="Saisie Obligatoire...")
     * @ORM\Column(name="note", type="float")
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="string", length=150)
     */
    private $image;


    /**
     * Get id
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
     * @return Film
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
     * Set description
     *
     * @param string $description
     * @return Film
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
     * Set dateDeRealisation
     *
     * @param \DateTime $dateDeRealisation
     * @return Film
     */
    public function setDateDeRealisation($dateDeRealisation)
    {
        $this->dateDeRealisation = $dateDeRealisation;

        return $this;
    }

    /**
     * Get dateDeRealisation
     *
     * @return \DateTime 
     */
    public function getDateDeRealisation()
    {
        return $this->dateDeRealisation;
    }

    /**
     * Set note
     *
     * @param float $note
     * @return Film
     */
    public function setNote($note)
    {
        $this->note = $note;

        return $this;
    }

    /**
     * Get note
     *
     * @return float 
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Film
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

    public function displayImage()
    {
        return "images/films/".$this->image;
    }



    /**
     * Set genre
     *
     * @param \Troiswa\BackBundle\Entity\Genres $genre
     * @return Films
     */
    public function setGenre(\Troiswa\BackBundle\Entity\Genres $genre = null)
    {
        $this->genre = $genre;

        return $this;
    }

    /**
     * Get genre
     *
     * @return \Troiswa\BackBundle\Entity\Genres 
     */
    public function getGenre()
    {
        return $this->genre;
    }


    private function getImageFolder()   // pour simplifier le chemin (refactoriser le code) ne pas avoir de doublons
    {
        return "images/films";
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


}
