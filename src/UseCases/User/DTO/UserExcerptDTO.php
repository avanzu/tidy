<?php
/**
 * UserExcerptDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Responders\User\IUserExcerpt;

class UserExcerptDTO implements IUserExcerpt
{
    public $id;
    public $userName;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }
}