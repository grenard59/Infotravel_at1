<?php

namespace Infotravel\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Infotravel\BlogBundle\Entity\Categorie;

class Categories implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $noms = array('News', 'Coup de coeur', 'Misc');

    foreach($noms as $i => $nom)
    {
      // On cr�e la cat�gorie
      $liste_categories[$i] = new Categorie();
      $liste_categories[$i]->setNom($nom);

      // On la persiste
      $manager->persist($liste_categories[$i]);
    }

    // On d�clenche l'enregistrement
    $manager->flush();
  }
}