<?php
/**
 * ComparisonTest.php
 * SilverTongue
 * Date: 16.04.18
 */

namespace Tidy\Tests\Unit\Components\DataAccess;


use Tidy\Components\DataAccess\Comparison;
use Tidy\Tests\MockeryTestCase;

class ComparisonTest extends MockeryTestCase
{
    /**
     * @dataProvider factoryMethods
     *
     * @param $method
     * @param $value
     * @param $operator
     */
    public function test_factory($method, $value, $operator)
    {
        $callback = [Comparison::class, $method];
        $this->assertTrue(is_callable($callback));
        $result = call_user_func($callback, $value);
        $this->assertEquals($value, $result->getValue());
        $this->assertEquals($operator, $result->getOperator());
    }

    public function factoryMethods()
    {
        return [
            'equalTo'           => ['equalTo', 'abc', Comparison::EQ],
            'containing'        => ['containing', 'xyz', Comparison::CONTAINS],
            'isTrue'            => ['isTrue', true, Comparison::EQ],
            'isFalse'           => ['isFalse', false, Comparison::EQ],
            'greaterThan'       => ['greaterThan', 10, Comparison::GT],
            'greaterOrEqualTo'  => ['greaterOrEqualTo', 10, Comparison::GTE],
            'lessThan'          => ['lessThan', 10, Comparison::LT],
            'lessThanOrEqualTo' => ['lessOrEqualTo', 10, Comparison::LTE],
            'istNotEmpty'       => ['isNotEmpty', null, Comparison::NEQ],
            'istEmpty'          => ['isEmpty', null, Comparison::EQ],
            'startsWith'        => ['startsWith', 'foo', Comparison::STARTS_WITH],
            'EndsWith'          => ['endsWith', 'bar', Comparison::ENDS_WITH],


        ];
    }


}
