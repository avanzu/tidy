<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Responders\Audit;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponse;
use Tidy\Tests\MockeryTestCase;

class ChangeResponseTransformerTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $transformer = new ChangeResponseTransformer();
        assertThat($transformer, is(notNullValue()));
    }

    public function test_transform()
    {

        $transformer = new ChangeResponseTransformer();
        $changes     = ChangeSet::make(
            Change::replace('new value', 'password'),
            Change::remove('elements/10'),
            Change::add('100', '/elements/20')
        );

        assertThat(count($changes), is(equalTo(3)));

        $result = $transformer->transform($changes);
        assertThat($result, is(anInstanceOf(IChangeResponse::class)));

        $expected = [
            [
                'op'    => Change::OP_REPLACE,
                'path'  => 'password',
                'value' => 'new value',
            ],
            [
                'op'   => Change::OP_REMOVE,
                'path' => 'elements/10',
            ],
            [
                'op'    => Change::OP_ADD,
                'path'  => '/elements/20',
                'value' => '100',
            ],
        ];

        assertThat($result->changes(), is(arrayContaining($expected)));
    }

}