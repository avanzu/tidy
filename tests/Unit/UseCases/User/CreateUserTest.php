<?php
/**
 * CreateUserTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use PHPUnit\Framework\TestCase;
use Tidy\UseCases\User\CreateUser;

class CreateUserTest extends TestCase
{
    private $useCase;

    public function testInstantiation()
    {
        $this->assertInstanceOf(CreateUser::class, $this->useCase);


    }


    protected function setUp()
    {
        $this->useCase = new CreateUser();
        //$this->builder = new CreateuserRequestBuilder();
    }


}
