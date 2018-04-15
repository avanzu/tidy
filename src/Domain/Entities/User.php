<?php
/**
 * User.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Entities;


/**
 * Class User
 */
abstract class User
{
    /**
     * @var
     */
    protected $userName;
    /**
     * @var
     */
    protected $id;
    /**
     * @var
     */
    protected $eMail;
    /**
     * @var
     */
    protected $password;
    /**
     * @var bool
     */
    protected $enabled = false;
    /**
     * @var
     */
    protected $token;

    /**
     * @var UserProfile
     */
    protected $profile;

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

    /**
     * @param $userName
     *
     * @return $this
     */
    public function setUserName($userName)
    {
        $this->userName = $userName;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getEMail()
    {
        return $this->eMail;
    }

    /**
     * @param mixed $eMail
     *
     * @return $this
     */
    public function setEMail($eMail)
    {
        $this->eMail = $eMail;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     *
     * @return $this
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     *
     * @return $this
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * @param $token
     *
     * @return $this
     */
    public function assignToken($token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return $this
     */
    public function clearToken()
    {
        $this->token = null;

        return $this;
    }

    public function getProfile()
    {
        return $this->profile;
    }

    public function assignProfile(UserProfile $profile)
    {
        $this->profile = $profile;

        return $this;
    }
}