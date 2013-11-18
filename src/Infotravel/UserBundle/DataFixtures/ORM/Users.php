<?php
namespace Infotravel\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Infotravel\UserBundle\Entity\User;

class Users implements FixtureInterface
{
  public function load(ObjectManager $manager)
  {
    $noms = array('winzou', 'John', 'Talus');

    foreach ($noms as $i => $nom) {
      $users[$i] = new User;

      $users[$i]->setUsername($nom);
      $users[$i]->setPassword($nom);

      $users[$i]->setSalt('');
      $users[$i]->setRoles(array());

      $manager->persist($users[$i]);
    }

    $manager->flush();
  }
}