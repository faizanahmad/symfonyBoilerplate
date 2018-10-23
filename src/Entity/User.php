<?php

namespace App\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Groups({"details"})
     */
    protected $id;

    /**
     * @Groups({"details"})
     */
    private $newPass;

    public function __construct()
    {
        parent::__construct();
        // your own logic
    }

    /**
     * @return mixed
     */
    public function getNewPass()
    {
        return $this->newPass;
    }

    /**
     * @param mixed $newPass
     */
    public function setNewPass($newPass): void
    {
        $this->newPass = $newPass;
    }
}
