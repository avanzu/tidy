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


}