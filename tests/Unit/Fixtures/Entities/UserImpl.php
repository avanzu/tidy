<?php
/**
 * UserImpl.php
 * tidy
 * Date: 08.04.18
 */

namespace Tidy\Tests\Unit\Fixtures\Entities;

use Tidy\Domain\Entities\User;

class UserImpl extends User
{


    protected function makeProfile($firstName, $lastName)
    {
        $profile = new UserProfileImpl();
        $profile->setFirstName($firstName)->setLastName($lastName);
        return $profile;
    }
}