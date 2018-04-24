<?php
/**
 * IResponse.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Responders\User;

interface IResponse
{
    public function getUserName();

    public function getId();

    public function getEMail();

    public function getPassword();

    public function isEnabled();

    public function getToken();

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();


}