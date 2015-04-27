<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{

    public function dashboardAction()
    {
        //die("Je suis dans le controller");
        //return new Response("message");


        $em=$this->getDoctrine()->getManager();

        $nbFilms = $em->getRepository("TroiswaBackBundle:Films")->getNombreDeFilms();
        $allFilms = $em->getRepository("TroiswaBackBundle:Films")->getAllFilms();
        $bestFilm = $em->getRepository("TroiswaBackBundle:Films")->getBestFilm();
        $nbActeurs = $em->getRepository("TroiswaBackBundle:Acteurs")->getNombreActeurs();
        $filmGenre = $em->getRepository("TroiswaBackBundle:Films")->getFilmGenre("Comedie");
        $lastFilms = $em->getRepository("TroiswaBackBundle:Films")->getLastFilms(5);
        $hommesFemmes = $em->getRepository("TroiswaBackBundle:Films")->getHommesFemmes();

        $nbGenres = $em->getRepository("TroiswaBackBundle:Genres")->getNombreGenres();

        return $this->render("TroiswaBackBundle:Main:dashboard.html.twig",["nbFilms"=>$nbFilms,
                                                                           "nbActeurs"=>$nbActeurs,
                                                                           "nbGenres"=>$nbGenres
            ]);
        // Main = nom du dossier dans views    dashboead.html.twig= nom du fichier html crée dans le dossier

    }
}