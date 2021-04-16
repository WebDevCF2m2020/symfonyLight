<?php

// attribution du namespace
namespace App\Controller;

// chargement de la classe abstraite gérant les contrôleurs dans Symfony
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// chargement du module de réponse
use Symfony\Component\HttpFoundation\Response;


/**
 * Description of DefaultController extends de AbstractController
 *
 * @author PITZ
 */
class DefaultController extends AbstractController {
    
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
}
