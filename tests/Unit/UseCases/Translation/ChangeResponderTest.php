<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Audit\ChangeResponseTransformer;
use Tidy\Domain\Responders\Audit\IChangeResponse;
use Tidy\Domain\Responders\Audit\IChangeResponseTransformer;
use Tidy\Tests\MockeryTestCase;

class ChangeResponderTest extends MockeryTestCase
{

    public function test_swap()
    {
        $transformer1 = mock(ChangeResponseTransformer::class);
        $transformer2 = mock(IChangeResponseTransformer::class);

        $obj = new ChangeResponderImpl(mock(ITranslationGateway::class), $transformer1);

        assertThat($obj->swapTransformer($transformer2), is($transformer1));
        assertThat($obj->swapTransformer($transformer1), is($transformer2));
    }

    public function test_transform()
    {
        $obj    = new ChangeResponderImpl(mock(ITranslationGateway::class));
        $result = $obj->run(ChangeSet::make(Change::add('some value', 'some/path')));
        assertThat($result, is(anInstanceOf(IChangeResponse::class)));
        assertThat(count($result), is(equalTo(1)));

    }
}