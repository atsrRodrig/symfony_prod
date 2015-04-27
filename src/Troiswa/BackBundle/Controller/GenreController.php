<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Troiswa\BackBundle\Entity\Genres;

class GenreController extends Controller
{
    public function creerAction(Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $nouveauGenre = new Genres();       // nouvel Objet déclaré du type Genres (class Genres dans Entity (Genres.php)

        // $nouveauGenre->setType("essai");         // pour tester on initialize le champ type du formulaire

        $form=$this->createFormBuilder($nouveauGenre)
            ->add("type","text")
            ->add("description","textarea")
            ->add("ajouter","submit")
            ->getForm();                            // RECUPERE LE FORMULAIRE


        /* Utiliser auntre methode ci-dessous   handleREquest
        if ($request->isMethod("POST"))
        {
            $form->submit($request);                // je le remplis avec les info tapees dans le formulaire

            //die(var_dump(($nouveauGenre)));

            if($form->isValid())
            {
                $em=$this->getDoctrine()->getManager();
                $em->persist($nouveauGenre);                // SURVEILLE L'OBJET

                // $nouveauGenre->setType("toto");          // POUR TEST A ENLEVER

                $em->flush();                               // ENRGISTRE DANS LA BASE

                $sessions=$request->getSession();
                $sessions->getFlashBag()->add("success_genre","Le genre a bien été ajouté");

                return $this->redirect($this->generateUrl("troiswa_back_genres"));
            }
        }
        */


        $form->handleRequest($request);

        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();
            $em->persist($nouveauGenre);                // SURVEILLE L'OBJET

            // $nouveauGenre->setType("toto");          // POUR TEST A ENLEVER

            $em->flush();                               // ENRGISTRE DANS LA BASE

            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_genre","Le genre a bien été ajouté");

            return $this->redirect($this->generateUrl("troiswa_back_genres"));
        }


        return $this->render("TroiswaBackBundle:Genres:creer.html.twig",['formGenre'=>$form->createView()]);
    }



    public function modifierAction($id,Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        //$Genre = new Genres();           // nouvel Objet déclaré du type Genres (class Genres dans Entity (Genres.php)
        //$Genre->setType("essai");         // pour tester on initialize le champ type du formulaire */


        $em=$this->getDoctrine()->getManager();
        $Genre=$em->getRepository("TroiswaBackBundle:Genres")->find($id);           // ENRGISTRE DANS LA BASE

        $form=$this->createFormBuilder($Genre)
            ->add("type","text")
            ->add("description","textarea")
            ->add("modifier","submit")
            ->getForm();                            // RECUPERE LE FORMULAIRE

        $form->handleRequest($request);

        if($form->isValid())
        {
            // $em->persist($nouveauGenre);            // SURVEILLE L'OBJET plus besoin car c'est doctrine qui l'a envoyé
            $em->flush();                              // ENRGISTRE DANS LA BASE

            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_genre","Le genre a bien été modifié");

            return $this->redirect($this->generateUrl("troiswa_back_genres"));
        }







        //return $this->redirect($this->generateUrl("troiswa_back_genres"));

        return $this->render("TroiswaBackBundle:Genres:modifier.html.twig",['formGenre'=>$form->createView()]);
    }


    public function supprimerAction($id,Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {

        $em=$this->getDoctrine()->getManager();
        $unGenre=$em->getRepository("TroiswaBackBundle:Genres")->find($id);  // Genres=class ENRGISTRE DANS LA BASE

        $em->remove($unGenre);
        $em->flush();                              // ENRGISTRE DANS LA BASE

        $sessions=$request->getSession();
        $sessions->getFlashBag()->add("delete_genre","Le genre a bien été supprimé");

        return $this->redirect($this->generateUrl("troiswa_back_genres"));

    }




    public function allAction()
    {
        // maintenant a partir de la BDD

        // $em = EntityManager  = $connexion $em est dans la doc officielle

        $em = $this->getDoctrine()->getManager(); // récupération de doctrine

        $allgenres = $em->getRepository("TroiswaBackBundle:Genres")->findAll();   // = fetchAll dans la class Acteurs (idem Model)


        //die(var_dump($allGenres));


        return $this->render("TroiswaBackBundle:Genres:genres.html.twig",['allGenres'=>$allgenres]);

        // Genres = nom du dossier dans views    genres.html.twig= nom du fichier html que nous avons crée
    }

}