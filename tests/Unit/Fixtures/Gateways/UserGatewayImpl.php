<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Tests\Unit\Fixtures\Gateways;

use Tidy\Components\Collection\Boundary;
use Tidy\Components\Collection\IPagedCollection;
use Tidy\Components\Events\IDispatcher;
use Tidy\Domain\Entities\User;
use Tidy\Domain\Entities\UserProfile;
use Tidy\Domain\Gateways\UserGateway;
use Tidy\Domain\Repositories\IUserRepository;
use Tidy\Tests\Unit\Fixtures\Entities\UserImpl;
use Tidy\Tests\Unit\Fixtures\Entities\UserProfileImpl;

/**
 * Class UserGatewayImpl
 */
class UserGatewayImpl extends UserGateway
{
    /**
     * @var IUserRepository
     */
    protected $repository;

    /**
     * UserGatewayImpl constructor.
     *
     * @param IUserRepository $repository
     * @param IDispatcher     $dispatcher
     */
    public function __construct(IUserRepository $repository, IDispatcher $dispatcher)
    {
        parent::__construct($dispatcher);
        $this->repository = $repository;
    }

    /**
     * @param User $user
     */
    protected function doSave(User $user)
    {
    }

    /**
     * @param Boundary $boundary
     * @param array    $criteria
     *
     * @return IPagedCollection|User[]
     */
    public function fetchCollection(Boundary $boundary, array $criteria = [])
    {
        return $this->repository->fetchCollection($boundary, $criteria);
    }

    /**
     * @param $userId
     *
     * @return null|User
     */
    public function find($userId)
    {
        return $this->repository->find($userId);
    }

    /**
     * @param $token
     *
     * @return null|User
     */
    public function findByToken($token)
    {
        return $this->repository->findByToken($token);
    }

    /**
     * @param $getUserName
     *
     * @return null|User
     */
    public function findByUserName($getUserName)
    {
        return $this->repository->findByUserName($getUserName);
    }

    /**
     * @return UserProfile
     */
    public function makeProfile()
    {
        return new UserProfileImpl();
    }

    /**
     * @return User
     */
    public function makeUser()
    {
        return new UserImpl();
    }

    /**
     * @param array $criteria
     *
     * @return int
     */
    public function total($criteria = [])
    {
        return $this->repository->total($criteria);
    }


}