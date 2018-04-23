<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\Components\Audit;

use Tidy\Components\Audit\Change;
use Tidy\Tests\MockeryTestCase;

class ChangeTest extends MockeryTestCase
{

    /**
     */
    public function test_factory_test()
    {
        $change = Change::test('abc', 'attribute');
        assertThat($change->op, is(equalTo(Change::OP_TEST)));
        assertThat($change->path, is(equalTo('attribute')));
        assertThat($change->value, is(equalTo('abc')));
        assertThat($change->from, is(nullValue()));
    }

    public function test_factory_add()
    {
        $change = Change::add('abc', 'attribute');
        assertThat($change->op, is(equalTo(Change::OP_ADD)));
        assertThat($change->path, is(equalTo('attribute')));
        assertThat($change->value, is(equalTo('abc')));
        assertThat($change->from, is(nullValue()));
    }

    public function test_factory_remove()
    {
        $change = Change::remove('attribute');
        assertThat($change->op, is(equalTo(Change::OP_REMOVE)));
        assertThat($change->path, is(equalTo('attribute')));
        assertThat($change->value, is(nullValue()));
        assertThat($change->from, is(nullValue()));
    }

    public function test_factory_replace()
    {
        $change = Change::replace( '999','attribute');
        assertThat($change->op, is(equalTo(Change::OP_REPLACE)));
        assertThat($change->path, is(equalTo('attribute')));
        assertThat($change->value, is(equalTo('999')));
        assertThat($change->from, is(nullValue()));
    }

    public function test_factory_move()
    {
        $change = Change::move( '/a/b','/a/c');
        assertThat($change->op, is(equalTo(Change::OP_MOVE)));
        assertThat($change->path, is(equalTo('/a/c')));
        assertThat($change->value, is(nullValue()));
        assertThat($change->from, is('/a/b'));
    }

    public function test_factory_copy()
    {
        $change = Change::copy( 'left','right');
        assertThat($change->op, is(equalTo(Change::OP_COPY)));
        assertThat($change->from, is('left'));
        assertThat($change->path, is(equalTo('right')));
        assertThat($change->value, is(nullValue()));
    }




}