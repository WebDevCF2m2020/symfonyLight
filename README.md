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

Pour créer la DB slight

    php bin/console doctrine:database:create

## Installation du profiler
Barre de gestion du fonctionnement de Symfony

    composer require profiler

Vous verrez une barre de profiling sur les pages avec un body

## Installation du maker
Permet de faire rapidement n'importe quel type d'actions

    composer require maker

### Création d'un contrôleur

    php bin/console make:controller

Création du contrôleur et de sa vue par défaut, la bonne pratique veut du UpperCamelCase et que la fin soit Nom"Controller"

### Création d'une entité

    php bin/console make:entity

permet la création d'une entité (équivalence d'un mapping d'une table), génère le mapping dans

    src/Entity

et crée son "manager"

    src/Repository

### Migration vers MariaDB

    php bin/console make:migration

création du fichier de migration

Effectuer la migration:

    php bin/console doctrine:migrations:migrate

Pour rajouter un champs à l'entité message (jointure ManyToOne avec theuser)

    php bin/console make:entity message

    > idtheuser
    > ManyToOne
    > TheUser
    > no
    > yes

### Affichage des theUser

Affichage des utilisateurs avec Doctrine

dans le contrôleur:

        src/controller/siteController.php
        ...
        use App\Entity\TheUser;
        ...
        // récupération de tous les utilisateurs en utilisant doctrine
        $users = $this->getDoctrine()
                    ->getRepository(TheUser::class)
                    ->findAll();
        // appel de la vue
        return $this->render('site/index.html.twig', [
            'users' => $users,
        ]);

dans Twig
    
    {% for item in users %}
    <h3>{{ item.getThename }}</h3>
    <p>{{ item.getThemail }} - <a href="{{ path("site_theuser_detail",{"slug":item.getThename}) }}">voir plus</a></p>
    {% endfor %}
    
### Affichage du détail d'un utilisateur

    src/controller/siteController.php
        ...
     /**
     * @Route("/{slug}", name="site_theuser_detail")
     */
    public function userDetail($slug): Response
    {
        // récupération d'un utilisateur en utilisant doctrine et son thename
        $user = $this->getDoctrine()
                    ->getRepository(TheUser::class)
                    ->findOneBy(["thename"=>$slug]);
        // appel de la vue
        return $this->render('site/user_detail.html.twig', [
            'theuser' => $user,
        ]);
    }

#### En cas d'utilisateur non trouvé
Utilisation de l'erreur 404 par défaut (sinon erreur 500)

    src/controller/siteController.php
    ...
    // récupération d'un utilisateur en utilisant doctrine et son thename
        $user = $this->getDoctrine()
                ->getRepository(TheUser::class)
                ->findOneBy(["thename" => $slug]);
        // pas de $user trouvé
        if (!$user) {
            // création d'une erreur 404
            throw $this->createNotFoundException(
                            "Pas d'utilisateur dont le nom est $slug"
            );
        }
        // appel de la vue
        return $this->render('site/user_detail.html.twig', [
                    'theuser' => $user,
        ]);

## chargement de la protection

    composer require security

## Créer un CRUD

    composer require form validator

    php bin/console make:crud

#### création d'un CRUD, rajouter le toString pour représenter les users

    src/Entity/TheUser.php
    ...
    // ce qu'on veut afficher quand l'objet doit être vu en tant que string
    public function __toString() {
        return $this->getThename();
    }

### Ajout d'un bootstrap

Enfant de base.html.twig, il va pemettre d'avoir un design minimal responsive pour nos autres pages

    templates/bootstrap_4.html.twig

#### activer les formulaires bootstrap par défaut

Dans le fichier:

    config/packages/twig.yaml
    ...
    twig:
        default_path: '%kernel.project_dir%/templates'
        form_themes: ['bootstrap_4_layout.html.twig']

