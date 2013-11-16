<?php

namespace Infotravel\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller {

    public function indexAction() {
        $articles = array(
            array(
                'titre' => 'Mon weekend a Phi Phi Island !',
                'id' => 1,
                'auteur' => 'winzou',
                'contenu' => 'Ce weekend était trop bien. Blabla?',
                'date' => new \Datetime()),
            array(
                'titre' => 'Repetition du National Day de Singapour',
                'id' => 2,
                'auteur' => 'winzou',
                'contenu' => 'Bientôt prêt pour le jour J. Blabla?',
                'date' => new \Datetime()),
            array(
                'titre' => 'Chiffre d\'affaire en hausse',
                'id' => 3,
                'auteur' => 'M@teo21',
                'contenu' => '+500% sur 1 an, fabuleux. Blabla?',
                'date' => new \Datetime())
        );
        return $this->render("BlogBundle:Blog:index.html.twig", array(
                    'articles' => $articles
        ));
    }

    public function voirAction($id) {
        $article = array(
            'id' => 1,
            'titre' => 'Mon weekend a Phi Phi Island !',
            'auteur' => 'winzou',
            'contenu' => 'Ce weekend était trop bien. Blabla?',
            'date' => new \Datetime()
        );

        // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
        return $this->render('BlogBundle:Blog:voir.html.twig', array(
                    'article' => $article
        ));
    }

    public function ajouterAction() {
        if ($this->get('request')->getMethod() == 'POST') {
            $this->get('session')->getFlashBag()->add('notice', "Article bien enregisté.");
            return $this->redirect($this->generateUrl('blog_voir', array(
                                'id' => 5,
            )));
        }
        return $this->render('BlogBundle:Blog:ajouter.html.twig');
    }

    public function modifierAction($id) {
        $article = array(
            'id' => 1,
            'titre' => 'Mon weekend a Phi Phi Island !',
            'auteur' => 'winzou',
            'contenu' => 'Ce weekend était trop bien. Blabla?',
            'date' => new \Datetime()
        );

        // Puis modifiez la ligne du render comme ceci, pour prendre en compte l'article :
        return $this->render('BlogBundle:Blog:modifier.html.twig', array(
                    'article' => $article
        ));
    }

    public function supprimerAction($id) {
        return $this->render('BlogBundle:Blog:supprimer.html.twig');
    }

    public function menuAction() {
        $liste = array(
            array('id' => 2, 'titre' => 'Infotravel'),
        );
        return $this->render('BlogBundle:Blog:menu.html.twig', array(
                    'liste_articles' => $liste,
        ));
    }

}

?>
