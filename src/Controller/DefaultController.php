<?php

// attribution du namespace
namespace App\Controller;

// chargement de la classe abstraite gérant les contrôleurs dans Symfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// chargement du module de réponse
use Symfony\Component\HttpFoundation\Response;

// chargement des annotations de Route
use Symfony\Component\Routing\Annotation\Route;


/**
 * Description of DefaultController extends de AbstractController
 *
 * @author PITZ
 */
class DefaultController extends AbstractController {
    
    /*
     * routage par yaml
     */
    
    public function index(){
        return new Response("Hello World!",200);
    }
    
    public function api(){
        $array = ["identité"=>
            ["nom"=>"Pitz","prénom"=>"Michaël"], 
            ["nom"=>"Sandron","prénom"=>"Pierre"],
                ];
        return $this->json($array);
    }
    
    public function helloToYou($name) {
        
        return new Response("Hello $name", 200);
        
    }
    
    /*
     * Routage par annotations
     */
    
    /**
     * @Route(name="page", path="/page/{idPage}",requirements={"idPage"="\d+"})
     * @param type $idPage
     * 
     */
    public function page($idPage) {
        $array = [1=>"lulu",2=>"lala",3=>"coucou"];
        return new Response($array[$idPage]);
    }
    /**
     * @Route(name="accueilBlog", path="/blog/")
     */
    public function accueilBlog(){
        return $this->render("blog/blog_index.html.twig", []);
    }
}
