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
use Tidy\Gateways\IUserGateway;

/**
 * Class InMemoryUserGateway
 */
class InMemoryUserGateway implements IUserGateway
{

    /**
     * @var array
     */
    public static $users = [];

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
}