# symfonyLight

## Prérequis de la version 5.2.*
- Il faut d'abord installer composer https://getcomposer.org/download/
- Puis installer Symfony (on peut utiliser composer pour cela, mais symfony offre plus de possibilités): https://symfony.com/download
- PHP en version 7.2.6 minimum
- Un système de BDD: MySQL, MariaDB (que j'utiliserai), MongoDB, PostgreSQL ...

### Antivirus

Désactivez votre antivirus si vous avez des problèmes d'installation.

### En cas de non installation de ssl

    symfony server:ca:install

## Création d'un projet light

    symfony new symfonyLight

## .env

Dupliquez .env en .env.local (en changeant lk) 

## mode console

    symfony console

    php bin/console

## démarage du serveur

    // en mo daemon (-d sans affichage des logs)
    symfony server:start -d 

    // pour stopper le serveur
    symfony server:stop

### affichage des routes

    php bin/console debug:router

pour le moment, on a seulement le chemin vers la page d'accueil par défaut

### Création du DefaultController.php

    src/Controller/DefaultController.php

    // attribution du namespace
    namespace App\Controller;

    // chargement de la classe abstraite gérant les contrôleurs dans Symfony
    use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

    // chargement du module de réponse
    use Symfony\Component\HttpFoundation\Response;

    class DefaultController extends AbstractController {
        public function index(){
            return new Response("Hello World!",200);
        }
    }

## Création des routes en Yaml

    config/routes.yaml

    index:
        path: /
        controller: App\Controller\DefaultController::index
    # exemple de json    
    api:
        path: /MyApi
        controller: App\Controller\DefaultController::api
    # gestion d'une variable get    
    hello:
        path: /hello/{name}
        controller: App\Controller\DefaultController::helloToYou
        defaults:
            name: "Anonymous"

Attention, le yaml est stricte pour les tabulations, nous ne l'utiliserons au final que pour les fichiers de configurations

### Liens avec le contrôleur

    src/Controller/DefaultController.php
    ...
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

## installation des annotations
Elles servent pour les routes, les mapping de bases de données, la documentation, les tests etc...

    composer require annotations

On peut ensuite les utiliser directement dans le contrôleur:

    src/Controller/DefaultController.php
    ...
    // chargement des annotations de Route
    use Symfony\Component\Routing\Annotation\Route;
    ...
    /**
     * @Route(name="page", path="/page/{idPage}",requirements={"idPage"="\d+"})
     * @param type $idPage
     * 
     */
    public function page($idPage) {
        $array = [1=>"lulu",2=>"lala",3=>"coucou"];
        return new Response($array[$idPage]);
    }
    
Vous pouvez maintenant voir l'url : https://127.0.0.1:8000/page/3

## Installation de Twig

Moteur de template:

    composer require Twig

dans le contrôleur:

    src/Controller/DefaultController.php
    ...
    /**
     * @Route(name="accueilBlog", path="/blog/")
     */
    public function accueilBlog(){
        return $this->render("blog/blog_index.html.twig", []);
    }

dans templates:

    templates/blog/blog_index.html.twig
    ....
    {# accueil du blog#}
    {% extends "base.html.twig" %}
    {% block title %}Bienvenue sur le blog{% endblock %}
    {% block haut %}<h1>Bienvenue sur le blog</h1>{% endblock %}
    {% block milieu %}Milieu Lien vers l'<a href="{{ path("api") }}">api</a>{% endblock %}
    {% block bas %}{% endblock %}

## Installation de l'ORM - Doctrine

Gestion des bases de données

    composer require orm

Changement dans le fichier de configuration .env.local

    DATABASE_URL="mysql://root:@127.0.0.1:3308/slight"