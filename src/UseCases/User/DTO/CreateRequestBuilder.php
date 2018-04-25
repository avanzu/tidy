<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\User\DTO;

class CreateRequestBuilder
{

    protected $userName;

    protected $plainPassword;

    protected $eMail;

    protected $enabled = false;

    protected $firstName;

    protected $lastName;

    public function grantImmediateAccess()
    {
        $this->enabled = true;

        return $this;
    }

    public function witFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function withEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

    public function withLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function withPlainPassword($plainPassword)
    {
        $this->plainPassword = $plainPassword;

        return $this;
    }

    public function withUserName($username)
    {
        $this->userName = $username;

        return $this;
    }

    public function build()
    {
        return new CreateRequestDTO(
            $this->userName,
            $this->plainPassword,
            $this->eMail,
            $this->enabled,
            $this->firstName,
            $this->lastName
        );
    }

}