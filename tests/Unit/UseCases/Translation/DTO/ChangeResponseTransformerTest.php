<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\DTO;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\Translation\DTO\ChangeResponseDTO;
use Tidy\UseCases\Translation\DTO\ChangeResponseTransformer;

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
        $changes     = ChangeSet::make()
                                ->add(Change::replace('new value', 'password'))
                                ->add(Change::remove('elements/10'))
                                ->add(Change::add('100', '/elements/20'))
        ;

        assertThat(count($changes), is(equalTo(3)));

        $result = $transformer->transform($changes);
        assertThat($result, is(anInstanceOf(ChangeResponseDTO::class)));

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