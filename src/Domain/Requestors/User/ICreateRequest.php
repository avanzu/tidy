<?php
/**
 * ICreateRequest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface ICreateRequest extends IPlainPassword
{


    public function getUserName();



    public function eMail();

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