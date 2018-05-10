<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Tests\Unit\Gateways;

use Mockery\MockInterface;
use Tidy\Components\AccessControl\IClaimantProvider;
use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Util\StringUtilFactory;
use Tidy\Domain\BusinessRules\UserRules;
use Tidy\Domain\Events\User\Registered;
use Tidy\Domain\Gateways\UserGateway;
use Tidy\Domain\Repositories\IUserRepository;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TimmyUser;
use Tidy\Tests\Unit\Fixtures\Gateways\UserGatewayImpl;
use Tidy\UseCases\User\DTO\CreateRequestBuilder;

class UserGatewayTest extends MockeryTestCase
{


    /**
     * @var UserGateway
     */
    protected $gateway;

    /***
     * @var IDispatcher|MockInterface
     */
    private $dispatcher;

    /**
     * @var IUserRepository|MockInterface
     */
    private $repository;

    public function testInstantiation()
    {
        $this->assertInstanceOf(IClaimantProvider::class, $this->gateway);
    }

    public function testLookUp()
    {
        $this->repository->expects('find')->with(TimmyUser::ID)->andReturns(new TimmyUser());
        $this->assertInstanceOf(TimmyUser::class, $this->gateway->lookUp(TimmyUser::ID));

    }
    public function testSave()
    {
        $user    = $this->gateway->makeUser();
        $request = (new CreateRequestBuilder())
            ->withUserName(TimmyUser::USERNAME)
            ->withEMail(TimmyUser::EMAIL)
            ->build()
        ;
        $rules = mock(UserRules::class);
        $rules->expects('verifyRegister');

        $user->register($request, $rules, new StringUtilFactory());
        $this->dispatcher->expects('broadcast')->with(anInstanceOf(Registered::class));

        $this->gateway->save($user);

        $this->assertCount(0, $user->events());

    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->dispatcher = mock(IDispatcher::class);
        $this->repository = mock(IUserRepository::class);
        $this->gateway    = new UserGatewayImpl($this->repository, $this->dispatcher);
    }
}