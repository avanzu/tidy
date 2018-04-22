<?php
/**
 * ICreateRequest.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Domain\Requestors\User;

interface ICreateRequest
{
    /**
     * @param $username
     *
     * @return ICreateRequest
     */
    public function withUserName($username);

    public function getUserName();

    /**
     * @param $plainPassword
     *
     * @return ICreateRequest
     */
    public function withPlainPassword($plainPassword);

    /**
     * @param $eMail
     *
     * @return ICreateRequest
     */
    public function withEMail($eMail);

    public function eMail();

    public function plainPassword();

    /**
     * @return ICreateRequest
     */
    public function grantImmediateAccess();

    public function isAccessGranted();

    /**
     * @param $firstName
     *
     * @return ICreateRequest
     */
    public function witFirstName($firstName);

    /**
     * @param $lastName
     *
     * @return ICreateRequest
     */
    public function withLastName($lastName);

    /**
     * @return string
     */
    public function firstName();

    /**
     * @return string
     */
    public function lastName();
}