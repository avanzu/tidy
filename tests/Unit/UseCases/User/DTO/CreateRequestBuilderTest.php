<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\User\DTO;

use Tidy\Domain\Requestors\User\ICreateRequest;
use Tidy\Tests\MockeryTestCase;
use Tidy\UseCases\User\DTO\CreateRequestBuilder;

class CreateRequestBuilderTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $builder = new CreateRequestBuilder();
        assertThat($builder, is(notNullValue()));

    }

    public function test_build()
    {
        $builder = new CreateRequestBuilder();
        $request = $builder
            ->witFirstName('Timmy')
            ->withLastName('Garcia')
            ->withUserName('untorst')
            ->withEMail('TimmyGarcia@jourrapide.com')
            ->withPlainPassword('cuoSeeph9')
            ->grantImmediateAccess()
            ->build()
        ;

        assertThat($request, is(anInstanceOf(ICreateRequest::class)));

    }

}