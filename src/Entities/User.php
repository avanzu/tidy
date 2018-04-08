<?php
/**
 * User.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Entities;


abstract class User
{
    protected $userName;
    protected $id;


    public function getId()
    {
        return $this->id;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function setUserName($userName)
    {
        $this->userName = $userName;
        return $this;
    }

}