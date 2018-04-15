<?php
/**
 * IUserExcerpt.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Responders\User;

interface IUserExcerpt
{
    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getUserName();
}