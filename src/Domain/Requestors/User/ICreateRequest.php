<?php
/**
 * ICreateRequest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface ICreateRequest
{


    public function getUserName();



    public function eMail();

    public function plainPassword();


    public function isAccessGranted();

    /**
     * @return string
     */
    public function firstName();

    /**
     * @return string
     */
    public function lastName();
}