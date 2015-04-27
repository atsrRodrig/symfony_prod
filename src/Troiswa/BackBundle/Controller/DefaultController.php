<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('TroiswaBackBundle:Default:index.html.twig', array('name' => $name));
    }

    public function tryAction()
    {
        //die("Je suis dans le controller");
        //return new Response("message");

        return $this->render("TroiswaBackBundle:Default:mapage.html.twig",["prenom"=>"Antonio"]);

        // default = nom du dossier dans views    mapage.html.twig= nom du fichier html que nous avons crée

    }
}
