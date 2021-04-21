<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// utilisation de TheUser (qui charge lui-même Doctrine et ses dépendances)
use App\Entity\TheUser;

/**
* @Route("/site")
*/
class SiteController extends AbstractController
{
    /**
     * @Route("/", name="site_accueil")
     */
    public function index(): Response
    {
        // récupération de tous les utilisateurs en utilisant doctrine
        $users = $this->getDoctrine()
                    ->getRepository(TheUser::class)
                    ->findAll();
        // appel de la vue
        return $this->render('site/index.html.twig', [
            'users' => $users,
        ]);
    }
    /**
     * @Route("/{slug}", name="site_theuser_detail")
     */
    public function userDetail($slug): Response
    {
        // récupération d'un utilisateur en utilisant doctrine et son thename
        $user = $this->getDoctrine()
                    ->getRepository(TheUser::class)
                    ->findOneBy(["thename"=>$slug]);
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
    }
}
