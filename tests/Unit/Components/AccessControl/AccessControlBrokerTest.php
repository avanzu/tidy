<?php
/**
 * AccessControlBrokerTest.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Components\AccessControl;


use Mockery\MockInterface;
use Tidy\Components\AccessControl\AccessControlBroker;
use Tidy\Components\AccessControl\IClaimantProvider;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Tests\MockeryTestCase;

class AccessControlBrokerTest extends MockeryTestCase
{
    /**
     * @var IClaimantProvider|MockInterface
     */
    protected $provider;

    /**
     * @var AccessControlBroker
     */
    protected $broker;

    public function test_instantiation()
    {
        $broker = new AccessControlBroker(mock(IClaimantProvider::class));
        $this->assertInstanceOf(AccessControlBroker::class, $broker);
    }

    public function test_transferOwnership_with_IClaimant_success()
    {
        $jimmy     = new ClaimantJimmy();
        $timmy     = new ClaimantTimmy();
        $claimable = new ClaimableImpl($jimmy);

        $result = $this->broker->transferOwnership($claimable, $timmy);

        $this->assertSame($jimmy, $result);
    }

    public function test_transferOwnership_with_ClaimantID_success()
    {
        $timmy     = new ClaimantTimmy();
        $jimmy     = new ClaimantJimmy();
        $claimable = new ClaimableImpl($timmy);
        $jimmyId   = ClaimantJimmy::ID;

        $this->expectLookUp($jimmyId, $jimmy);

        $result = $this->broker->transferOwnership($claimable, $jimmyId);

        $this->assertSame($timmy, $result);
    }

    public function test_transferOwnership_with_ClaimantID_failure()
    {
        $unexpectedID = 9999999;
        $claimable    = new ClaimableImpl(new ClaimantJimmy());

        $this->expectLookUp($unexpectedID, null);
        $this->expectException(NotFound::class);

        $this->broker->transferOwnership($claimable, $unexpectedID);

    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        $this->provider = mock(IClaimantProvider::class);
        $this->broker   = new AccessControlBroker($this->provider);
    }

    /**
     * @param $jimmyId
     * @param $jimmy
     */
    private function expectLookUp($jimmyId, $jimmy)
    {
        $this->provider->expects('lookUp')->with($jimmyId)->andReturn($jimmy);
    }


}