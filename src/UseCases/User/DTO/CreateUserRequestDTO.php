<?php
/**
 * CreateUserRequestDTO.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\UseCases\User\DTO;


class CreateUserRequestDTO
{
    public    $userName;
    public    $plainPassword;
    public    $eMail;
    protected $enabled = false;

    /**
     * @return CreateUserRequestDTO
     */
    public static function create()
    {
        return new static;
    }

    /**
     * @param $username
     *
     * @return CreateUserRequestDTO
     */
    public function withUserName($username)
    {
        $this->userName = $username;

        return $this;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param $plainPassword
     *
     * @return CreateUserRequestDTO
     */
    public function withPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    /**
     * @param $eMail
     *
     * @return CreateUserRequestDTO
     */
    public function withEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

    public function getEMail() {
        return $this->eMail;
    }

    public function getPlainPassword() {
        return $this->plainPassword;
    }

    /**
     * @return CreateUserRequestDTO
     */
    public function grantImmediateAccess() {
        $this->enabled = true;
        return $this;
    }

    public function isAccessGranted()
    {
        return (bool)$this->enabled;
    }

}