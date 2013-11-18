<?php

namespace Infotravel\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User
 * @ORM\Entity
 * @ORM\Table("info_user")
 */
class User extends BaseUser {

    public function __construct() {
        parent::__construct();
        $this->roles = array();
    }

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

}
