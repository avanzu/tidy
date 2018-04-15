<?php
/**
 * IUserGateway.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Gateways;


use Tidy\Entities\User;
use Tidy\Entities\UserProfile;
use Tidy\Exceptions\NotFound;

interface IUserGateway
{

    /**
     * @param $userId
     *
     * @return User
     * @throws NotFound
     */
    public function find($userId);

    /**
     * @param $page
     * @param $pageSize
     *
     * @return User[]
     */
    public function fetchCollection($page, $pageSize);

    /**
     * @return int
     */
    public function getTotal();

    /**
     * @param User $user
     *
     * @return mixed
     */
    public function save(User $user);

    /**
     * @return User
     */
    public function makeUser();

    /**
     * @return UserProfile
     */
    public function makeProfile();

    /**
     * @param $token
     *
     * @return User|null
     */
    public function findByToken($token);

    /**
     * @param $getUserName
     *
     * @return User|null
     */
    public function findByUserName($getUserName);

}