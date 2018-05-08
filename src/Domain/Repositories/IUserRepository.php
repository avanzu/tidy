<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\Repositories;

use Tidy\Components\Collection\IPagedCollection;
use Tidy\Domain\Entities\User;

interface IUserRepository
{

    /**
     * @param $userId
     *
     * @return User|null
     */
    public function find($userId);

    /**
     * @param $boundary
     * @param $criteria
     *
     * @return IPagedCollection
     */
    public function fetchCollection($boundary, $criteria);

    /**
     * @param $criteria
     *
     * @return int
     */
    public function total($criteria);

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