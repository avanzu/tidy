<?php
/**
 * UserStub2.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\Fixtures\Entities;

use Tidy\Domain\Entities\User;

class UserStub2 extends User {
    const ID       = 999;
    const USERNAME = 'John';

    protected $id       = self::ID;
    protected $userName = self::USERNAME;

    /**
     * UserStub2 constructor.
     *
     * @param null $token
     */
    public function __construct($token = NULL) {
        $this->token = $token;
    }


    protected function makeProfile($firstName, $lastName) {
        $profile = new UserProfileImpl();
        $profile->setFirstName($firstName)->setLastName($lastName);

        return $profile;
    }


}