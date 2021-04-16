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

    