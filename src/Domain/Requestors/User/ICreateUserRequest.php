<?php
/**
 * ICreateUserRequest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface ICreateUserRequest
{
    /**
     * @param $username
     *
     * @return ICreateUserRequest
     */
    public function withUserName($username);

    public function getUserName();

    /**
     * @param $plainPassword
     *
     * @return ICreateUserRequest
     */
    public function withPlainPassword($plainPassword);

    /**
     * @param $eMail
     *
     * @return ICreateUserRequest
     */
    public function withEMail($eMail);

    public function getEMail();

    public function getPlainPassword();

    /**
     * @return ICreateUserRequest
     */
    public function grantImmediateAccess();

    public function isAccessGranted();

    /**
     * @param $firstName
     *
     * @return ICreateUserRequest
     */
    public function witFirstName($firstName);

    /**
     * @param $lastName
     *
     * @return ICreateUserRequest
     */
    public function withLastName($lastName);

    /**
     * @return string
     */
    public function getFirstName();

    /**
     * @return string
     */
    public function getLastName();
}