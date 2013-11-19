<?php

namespace Infotravel\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Infotravel\BlogBundle\Entity\Tags;

class Tags implements FixtureInterface {

    public function load(ObjectManager $manager) {
        $noms = array('infotravel', 'test1', 'test2');

        foreach ($noms as $i => $nom) {
            $liste_tags[$i] = new Tags();
            $liste_tags[$i]->setNom($nom);

            $manager->persist($liste_tags[$i]);
        }
        $manager->flush();
    }

}

?>
