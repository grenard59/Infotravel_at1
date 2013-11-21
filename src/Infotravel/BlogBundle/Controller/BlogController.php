<?php

namespace Infotravel\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Infotravel\BlogBundle\Entity\Article;
use Infotravel\BlogBundle\Form\ArticleType;
use Infotravel\BlogBundle\Form\ArticleEditType;
use JMS\SecurityExtraBundle\Annotation\Secure;

class BlogController extends Controller {

    public function categorieAction($id) {

        $em = $this->getDoctrine()
                ->getManager();
        $categorie = $em->getRepository('BlogBundle:Categorie')
                ->find($id);
    
        $articles = $em->getRepository('BlogBundle:Article')
                ->getAvecCategorie(array($categorie->getNom()));
     
 

        return $this->render("BlogBundle:Blog:indexCategorie.html.twig", array(
                    'articles' => $articles,
                    'page' => 1,
                    'nombrePage' => ceil(count($articles) / 3),
        ));
    }

    public function indexAction($page) {
        if ($page < 1)
            $this->page = 1;
        $em = $this->getDoctrine()
                ->getManager();
        $article = $em->getRepository('BlogBundle:Article')
                ->getArticles(3, $page);
        return $this->render("BlogBundle:Blog:index.html.twig", array(
                    'articles' => $article,
                    'page' => $page,
                    'nombrePage' => ceil(count($article) / 3),
        ));
    }

    public function voirAction(Article $article) {

        return $this->render('BlogBundle:Blog:voir.html.twig', array(
                    'article' => $article,
        ));
    }

    /**
     * @Secure(roles="ROLE_AUTEUR")
     */
    public function ajouterAction() {
        $article = new Article();
        $form = $this->createForm(new ArticleType, $article);
        $req = $this->getRequest();

        if ($req->getMethod() == 'POST') {
            $form->bind($req);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($article);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Article bien ajouté');
                return $this->redirect($this->generateUrl('blog_voir', array(
                                    'id' => $article->getId(),
                )));
            }
        }
        return $this->render('BlogBundle:Blog:ajouter.html.twig', array(
                    'form' => $form->createView(),
        ));
    }

    /**
     * @Secure(roles="ROLE_AUTEUR")
     */
    public function modifierAction(Article $article) {
        $form = $this->createForm(new ArticleEditType, $article);
        $req = $this->getRequest();

        if ($req->getMethod() == 'POST') {
            $form->bind($req);
            if ($form->isValid()) {
                $em = $this->getDoctrine()
                        ->getManager();
                $em->persist($article);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Article bien modifié');
                return $this->redirect($this->generateUrl('blog_voir', array(
                                    'id' => $article->getId(),
                )));
            }
        }
        return $this->render("BlogBundle:Blog:modifier.html.twig", array(
                    'form' => $form->createView(),
                    'article' => $article,
        ));
    }

    /**
     * @Secure(roles="ROLE_AUTEUR")
     */
    public function supprimerAction(Article $article) {
        $form = $this->createFormBuilder()->getForm();

        $request = $this->getRequest();
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->remove($article);
                $em->flush();
                $this->get('session')->getFlashBag()->add('info', 'Article bien supprimé');
                return $this->redirect($this->generateUrl('blog_accueil'));
            }
        }
        return $this->render('BlogBundle:Blog:supprimer.html.twig', array(
                    'article' => $article,
                    'form' => $form->createView()
        ));
    }

    public function menuAction($nombre) {
        $em = $this->getDoctrine()
                ->getManager();
        $liste = $em->getRepository('BlogBundle:Article')
                ->findBy(
                array(), array('date' => 'desc'), $nombre, 0
        );

        $categorie = $em->getRepository('BlogBundle:Categorie')
                ->findAll();
        return $this->render('BlogBundle:Blog:menu.html.twig', array(
                    'liste_articles' => $liste,
                    'categories' => $categorie,
        ));
    }

}

?>
