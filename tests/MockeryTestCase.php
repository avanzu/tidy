<?php
/**
 * MockeryTestCase.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Tests;

use Exception;
use Hamcrest\MatcherAssert;
use Mockery\Adapter\Phpunit\MockeryTestCase as PhpUnitAdapter;

class MockeryTestCase extends PhpUnitAdapter
{
    public function runBare(): void
    {
        /**
         * Collects assertions performed by Hamcrest matchers during the test.
         */
        MatcherAssert::resetCount();
        try {
            parent::runBare();
        } catch (Exception $e) {
            // rethrown below
        }
        $this->addToAssertionCount(MatcherAssert::getCount());
        if (isset($e)) {
            throw $e;
        }
    }

    public function assertIssUuid($input)
    {
        $this->assertRegExp('/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i', $input);
    }


}