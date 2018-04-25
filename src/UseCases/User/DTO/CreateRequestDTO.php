<?php
/**
 * CreateRequestDTO.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Domain\Requestors\User\ICreateRequest;

class CreateRequestDTO implements ICreateRequest
{
    protected $userName;

    protected $plainPassword;

    protected $eMail;

    protected $enabled = false;

    protected $firstName;

    protected $lastName;

    /**
     * CreateRequestDTO constructor.
     *
     * @param      $userName
     * @param      $plainPassword
     * @param      $eMail
     * @param bool $enabled
     * @param      $firstName
     * @param      $lastName
     */
    public function __construct($userName, $plainPassword, $eMail, $enabled, $firstName, $lastName)
    {
        $this->userName      = $userName;
        $this->plainPassword = $plainPassword;
        $this->eMail         = $eMail;
        $this->enabled       = $enabled;
        $this->firstName     = $firstName;
        $this->lastName      = $lastName;
    }


    public function eMail()
    {
        return $this->eMail;
    }

    public function firstName()
    {
        return $this->firstName;
    }

    public function getUserName()
    {
        return $this->userName;
    }

    public function isAccessGranted()
    {
        return (bool)$this->enabled;
    }

    public function lastName()
    {
        return $this->lastName;
    }

    public function plainPassword()
    {
        return $this->plainPassword;
    }

}