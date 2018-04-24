<?php
/**
 * IUserGateway.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Domain\Gateways;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Entities\UserProfile;

interface IUserGateway
{

    /**
     * @param $userId
     *
     * @return User
     * @throws \Tidy\Components\Exceptions\NotFound
     */
    public function find($userId);

    /**
     * @param Boundary     $boundary
     * @param Comparison[] $criteria
     *
     * @return User[]
     */
    public function fetchCollection(Boundary $boundary, array $criteria = []);

    /**
     * @param Comparison[] $criteria
     *
     * @return int
     */
    public function total($criteria = []);

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