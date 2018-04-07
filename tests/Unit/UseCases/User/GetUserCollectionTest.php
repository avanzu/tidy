<?php
/**
 * GetUserCollectionTest.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\Tests\Unit\UseCases\User;

use PHPUnit\Framework\TestCase;
use Tidy\UseCases\User\GetUserCollection;

class GetUserCollectionTest extends TestCase
{
    /**
     * @var GetUserCollection
     */
    private $useCase;

    public function testInstantiation()
    {
        $this->assertInstanceOf(GetUserCollection::class, $this->useCase);
    }



    protected function setUp()
    {
        $this->useCase = new GetUserCollection();
    }

}
