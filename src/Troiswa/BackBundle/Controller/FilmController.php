<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\BackBundle\Entity\Films;
use Symfony\Component\Validator\Constraints\NotBlank;

class FilmController extends Controller
{

    public function allFilmsAction()
    {

        // maintenant a partir de la BDD

        // $em = EntityManager  = $connexion $em est dans la doc officielle

        $em = $this->getDoctrine()->getManager(); // récupération de doctrine

        $allFilms = $em->getRepository("TroiswaBackBundle:Films")->findAll();   // = fetchAll dans la classe Film rep Entity

        //die(var_dump($allActeurs));


        return $this->render("TroiswaBackBundle:Films:films.html.twig",['allFilms'=>$allFilms]);

        // default = nom du dossier dans views    mapage.html.twig= nom du fichier html que nous avons crée
    }


    public function informationAction($id)
    {

        // maintenant a partir de la BDD

        // $em = EntityManager  = $connexion $em est dans la doc officielle

        $em = $this->getDoctrine()->getManager(); // récupération de doctrine

        $unFilm = $em->getRepository("TroiswaBackBundle:Films")->find($id);   // = unbufered dans la classe Film rep Entity

        //die(var_dump($unActeur));

        return $this->render("TroiswaBackBundle:Films:infoFilm.html.twig",['unFilm'=>$unFilm]);
        // Films = nom du dossier des views    infoFilm.html.twig = nom du fichier html que nous avons crée

    }

    public function supprimerAction($id,Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $em=$this->getDoctrine()->getManager();
        $unFilm=$em->getRepository("TroiswaBackBundle:Films")->find($id);  // Acteurs=class ENRGISTRE DANS LA BASE

        $em->remove($unFilm);
        $em->flush();                              // ENRGISTRE DANS LA BASE

        $sessions=$request->getSession();
        $sessions->getFlashBag()->add("delete_film","Le film a bien été supprimé");

        return $this->redirect($this->generateUrl("troiswa_back_films"));
    }


    public function creerAction(Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $newFilm = new Films();                     // nouvel Objet déclaré du type Films (class Filmss dans Entity (Films.php)

        $form=$this->createFormBuilder($newFilm)
            ->add("titre","text")
            ->add("description","textarea")
            ->add('dateDeRealisation', 'date', array(
                'years' => range(date('Y')-120,date('Y')),
                'format' => 'dd-MM-yyyy' ))
            ->add("note","integer")
            ->add("fichier","file",["constraints"=>new NotBlank(["message"=>"Image obligatoire"]) ])   // changé le nom du champ 'image' pour 'fichier' qui est dan la methode upload et le type 'text' pour 'file'
            ->add('genre','entity', array(                  // genre = nom de la proprieté dans la class Films qui correspondt a la colonne genre de la table
                'class' => 'TroiswaBackBundle:Genres',
                'property' => 'type' ))         // c'est la propriété déclarée dans la classe "Genres" qui correspond a la colonne "type" de la table "genre"
            ->add("ajouter","submit")
            ->getForm();                                // RECUPERE LE FORMULAIRE

        $form->handleRequest($request);

        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();

            $newFilm->upload();                   // charge l'image en la choisissant

            $em->persist($newFilm);                     // SURVEILLE L'OBJET

            $em->flush();                               // ENRGISTRE DANS LA BASE

            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_film","Le film a bien été ajouté");

            return $this->redirect($this->generateUrl("troiswa_back_films"));
        }
        else
        {
            /*  // procedure qui permet d'afficher les erreurs pour analyser fait par ludo le 24/04/2015
            $validator = $this->get('validator');
            $errors = $validator->validate($form);
            foreach($errors as $e)
            {
                var_dump($e);
            }
            die();
            */
        }
        return $this->render("TroiswaBackBundle:Films:creer.html.twig",['formFilm'=>$form->createView()]);
    }


    public function modifierAction($id,Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $em=$this->getDoctrine()->getManager();
        $unFilm=$em->getRepository("TroiswaBackBundle:Films")->find($id);  // Films=class ENRGISTRE DANS LA BASE

        $form=$this->createFormBuilder($unFilm)
            ->add("titre","text")
            ->add("description","textarea")
            ->add('dateDeRealisation', 'date', array(
                'years' => range(date('Y')-120,date('Y')),
                'format' => 'dd-MM-yyyy' ))
            ->add("note","integer")
            ->add("fichier","file",["constraints"=>new NotBlank(["message"=>"Image obligatoire"]) ])   // changé le nom du champ 'image' pour 'fichier' qui est dan la methode upload et le type 'text' pour 'file'
            ->add('genre','entity', array(         // genre=nom de la proprieté dans la class Films qui correspond a la colonne genre de la tablea
                'class' => 'TroiswaBackBundle:Genres',  // la class Genres dans Entity  et fichier Genres.php
                'property' => 'type'
                ))         // c'est la propriété déclare dans la classe "Genres" qui correspond a la colonne "type" de la table "genre"
            ->add("valider","submit")
            ->getForm();                                // RECUPERE LE FORMULAIRE
        $form->handleRequest($request);

        if($form->isValid())
        {
            $em->flush();                               // ENRGISTRE DANS LA BASE

            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_film","Le film a bien été modifié");

            return $this->redirect($this->generateUrl("troiswa_back_films"));
        }

        return $this->render("TroiswaBackBundle:Films:modifier.html.twig",['formFilm'=>$form->createView()]);
    }
}