<?php
/**
 * InMemoryUserGateway.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\Gateways;


use Tidy\Entities\User;
use Tidy\Exceptions\NotFound;
use Tidy\Exceptions\OutOfBounds;
use Tidy\Exceptions\PersistenceFailed;
use Tidy\Gateways\IUserGateway;
use Tidy\Tests\Unit\Entities\UserImpl;

/**
 * Class InMemoryUserGateway
 */
class InMemoryUserGateway implements IUserGateway
{

    /**
     * @var array
     */
    public static $users = [];

    public static $userClass = UserImpl::class;

    /**
     * InMemoryUserGateway constructor.
     */
    public function __construct()
    {
        self::$users = [];
    }

    /**
     * @param $page
     * @param $pageSize
     *
     * @return array|User
     */
    public function fetchCollection($page, $pageSize)
    {
        $offset = max($page - 1, 0) * $pageSize;
        if ($offset > $this->getTotal()) {
            throw new OutOfBounds('Offset exceeds total available items.');
        }


        return array_slice(self::$users, $offset, $pageSize);
    }

    /**
     * @return int
     */
    public function getTotal()
    {
        return count(self::$users);
    }

    /**
     * @param $getUserId
     *
     * @return User
     * @throws NotFound
     */
    public function find($getUserId)
    {
        if (isset(self::$users[$getUserId])) {
            return self::$users[$getUserId];
        }

        throw new NotFound('User not found.');
    }

    public function save(User $user)
    {
        if (!$user->getId()) {
            $this->assignUserId($user);
        }

        self::$users[$user->getId()] = $user;
    }

    /**
     * @param User $user
     */
    private function assignUserId(User $user)
    {
        try {
            $userId     = (int)(time().count(self::$users));
            $reflection = new \ReflectionClass(self::$userClass);
            $property   = $reflection->getProperty('id');
            if (!$property->isPublic()) {
                $property->setAccessible(true);
            }

            $property->setValue($user, $userId);

        } catch(\Exception $reason) {
            throw new PersistenceFailed();
        }

    }

    /**
     * @return User
     */
    public function produce()
    {
        return new self::$userClass;
    }
}