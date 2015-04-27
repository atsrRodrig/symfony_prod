<?php

namespace Troiswa\BackBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Troiswa\BackBundle\Entity\Acteurs;

class ActeurController extends Controller
{

    public function allacteursAction(Request $request)
    {
        //die("Je suis dans le controller");
        //return new Response("message");

        /*  tableau pour notre test
        $allActeurs = [
                        ["id"=>"2","nom"=>"DUPONT","prenom"=>"Robert","dateNaissance"=>"20/01/1970","sexe"=>"0"],
                        ["id"=>"4","nom"=>"DUBOIS","prenom"=>"Jules","dateNaissance"=>"14/11/1952","sexe"=>"0"],
                        ["id"=>"7","nom"=>"MARTIN","prenom"=>"Emilie","dateNaissance"=>"12/02/1945","sexe"=>"1"]
                      ];
        */




        // maintenant a partir de la BDD

        // $em = EntityManager  = $connexion $em est dans la doc officielle

        $em = $this->getDoctrine()->getManager(); // récupération de doctrine


        $sql   = "SELECT a FROM TroiswaBackBundle:Acteurs a";
        $allActeurs = $em->createQuery($sql);

        // ne peut plus etre utilise avec le sorting dans la vue par le Nom
        // $allActeurs = $em->getRepository("TroiswaBackBundle:Acteurs")->findAll();   // = fetchAll dans la class Acteurs (idem Model)


        // pour la pagination
        $paginator  = $this->get('knp_paginator');

        $paginationActeurs = $paginator->paginate(
            $allActeurs,
            $request->query->get('page', 1)/*page number*/,
            2/*limit per page*/
        );




        //die(var_dump($allActeurs));

        //return $this->render("TroiswaBackBundle:Acteurs:acteurs.html.twig",['allActeurs'=>$allActeurs]); // remplace en dessous
        return $this->render("TroiswaBackBundle:Acteurs:acteurs.html.twig",['allActeurs'=>$paginationActeurs]);


        // default = nom du dossier dans views    mapage.html.twig= nom du fichier html que nous avons crée
    }




    public function creerAction(Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $newActeur = new Acteurs();           // nouvel Objet déclaré du type Acteurs (class Acteurs dans Entity (Acteurs.php)

        $form=$this->createFormBuilder($newActeur)
            ->add('sexe','choice', array(
                'choices'   => array('0' => 'Masculin', '1' => 'Féminin'),
                'expanded'  => true,
                'multiple'  => false))
            ->add("prenom","text")
            ->add("nom","text")
            ->add('dateNaissance', 'date', array(
                'years' => range(date('Y')-120,date('Y')),
                'format' => 'dd-MM-yyyy' ))
            ->add("ville","text")
            ->add("biographie","textarea")
            ->add("fichier","file",["constraints"=>new NotBlank(["message"=>"Image obligatoire"]) ])
            ->add("liaisonFilms","entity",["class"=>"TroiswaBackBundle:Films",
                                            "property"=>"titre",
                                            "multiple"=>true])
            ->add("ajouter","submit")
            ->getForm();                                // RECUPERE LE FORMULAIRE


        $form->handleRequest($request);

        if($form->isValid())
        {
            $em=$this->getDoctrine()->getManager();

            $newActeur->upload();                   // charge l'image en la choisissant

            $em->persist($newActeur);                   // SURVEILLE L'OBJET
            $em->flush();                               // ENRGISTRE DANS LA BASE

            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_acteur","L'acteur a bien été ajouté");

            return $this->redirect($this->generateUrl("troiswa_back_acteurs"));
        }

        return $this->render("TroiswaBackBundle:Acteurs:creer.html.twig",['formActeur'=>$form->createView()]);
    }



    public function modifierAction($id,Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {

        $em=$this->getDoctrine()->getManager();
        $unActeur=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);  // Acteurs=class ENRGISTRE DANS LA BASE

        $form=$this->createFormBuilder($unActeur)
            ->add('sexe','choice', array(
                'choices'   => array('0' => 'Masculin', '1' => 'Féminin'),
                'expanded'  => true,
                'multiple'  => false))
            ->add("prenom","text")
            ->add("nom","text")
            //->add('dateNaissance', 'date', ['format'=>'dd-MM-yyyy',])
            ->add('dateNaissance', 'date', array(
                'years' => range(date('Y')-120,date('Y')),
                'format' => 'dd-MM-yyyy' ))
            ->add("ville","text")
            ->add("biographie","textarea")
            ->add("fichier","file",["constraints"=>new NotBlank(["message"=>"Image obligatoire"]) ]) //changé le nom du champ 'image' pour 'fichier' qui est dans la methode upload et le type 'text' pour 'file'
            ->add("modifier","submit")
            ->getForm();                            // RECUPERE LE FORMULAIRE

        $form->handleRequest($request);

        if($form->isValid())
        {
            // $em->persist($nouveauGenre);            // SURVEILLE L'OBJET plus besoin car c'est doctrine qui l'a envoyé
            $em->flush();                              // ENRGISTRE DANS LA BASE

            $sessions=$request->getSession();
            $sessions->getFlashBag()->add("success_acteur","L'acteur a bien été modifié");

            return $this->redirect($this->generateUrl("troiswa_back_acteurs"));
        }

        return $this->render("TroiswaBackBundle:Acteurs:modifier.html.twig",['formActeur'=>$form->createView()]);
    }


    public function supprimerAction($id,Request $request)   // $_POST et $_GET et autres iformations supplémentaires
    {
        $em=$this->getDoctrine()->getManager();
        $unActeur=$em->getRepository("TroiswaBackBundle:Acteurs")->find($id);  // Acteurs=class ENRGISTRE DANS LA BASE

        $em->remove($unActeur);
        $em->flush();                              // ENRGISTRE DANS LA BASE

        $sessions=$request->getSession();
        $sessions->getFlashBag()->add("delete_acteur","L'acteur a bien été supprimé");

        return $this->redirect($this->generateUrl("troiswa_back_acteurs"));
    }


    public function informationAction($id)
    {
        /*
        $allActeurs = [
            ["id"=>"2","nom"=>"DUPONT","prenom"=>"Robert","dateNaissance"=>"20/01/1970","sexe"=>"0"],
            ["id"=>"4","nom"=>"DUBOIS","prenom"=>"Jules","dateNaissance"=>"14/11/1952","sexe"=>"0"],
            ["id"=>"7","nom"=>"MARTIN","prenom"=>"Emilie","dateNaissance"=>"12/02/1945","sexe"=>"1"]
        ];

        // ce n'est plus necessaire
        foreach($allActeurs as $key => $unActeur)
         {
            //die(var_dump($unActeur));

            if($unActeur['id'] == intval($id))
            {
                //die(var_dump($unActeur));
                return $this->render("TroiswaBackBundle:Acteurs:infoActeur.html.twig",['unActeur'=>$unActeur]);

            }
        }

        //die(var_dump($id));
        */



        // maintenant a partir de la BDD

        // $em = EntityManager  = $connexion $em est dans la doc officielle

        $em = $this->getDoctrine()->getManager(); // récupération de doctrine

        $unActeur = $em->getRepository("TroiswaBackBundle:Acteurs")->find($id);   // = unbufered dans la class Acteurs

        //die(var_dump($unActeur));


        if(empty($unActeur))
        {
            throw $this->createNotFoundException("Cet acteur n'existe pas");
        }

        return $this->render("TroiswaBackBundle:Acteurs:infoActeur.html.twig",['unActeur'=>$unActeur]);
    }
}