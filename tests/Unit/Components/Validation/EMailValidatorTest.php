<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Tests\Unit\Components\Validation;

use Egulias\EmailValidator\Exception\InvalidEmail;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;
use Tidy\Components\Validation\Validators\EMailValidator;
use Tidy\Tests\MockeryTestCase;
use Egulias\EmailValidator\EmailValidator as EguliasValidator;

class EMailValidatorTest extends MockeryTestCase
{

    public function test_validator()
    {
        $validator = new EMailValidator();
        $this->assertFalse($validator->validate('test@example..com'));
        $this->assertCount(1, $validator->violations());


        $this->assertFalse($validator->validate('ǉeto@lРaypal.com'));
        $this->assertCount(1, $validator->violations());


    }

    public function test_validate()
    {
        $egulias   = mock(EguliasValidator::class);
        $validator = new EMailValidator($egulias);

        $egulias->shouldReceive('isValid')->with('test[at]example.com', anInstanceOf(MultipleValidationWithAnd::class))->andReturn(false);
        $egulias->shouldReceive('isValid')->with('test[at]example.com', anInstanceOf(RFCValidation::class))->andReturn(false);
        $egulias->shouldReceive('isValid')->with('test[at]example.com', anInstanceOf(SpoofCheckValidation::class))->andReturn(false);
        $egulias->shouldReceive('getError')->andReturn(mock(InvalidEmail::class));

        $this->assertFalse($validator->validate('test[at]example.com'));

    }

    public function test_validateFormatOnly()
    {
        $egulias   = mock(EguliasValidator::class);
        $validator = new EMailValidator($egulias);

        $egulias->expects('isValid')->with('test@example.com',anInstanceOf(RFCValidation::class))->andReturn(false);
        $egulias->shouldReceive('getError')->andReturn(mock(InvalidEmail::class));
        $validator->validateFormatOnly('test@example.com');

    }

    public function test_validateSpoof()
    {
        $egulias   = mock(EguliasValidator::class);
        $validator = new EMailValidator($egulias);

        $egulias->shouldReceive('isValid')->with('test@example.com', anInstanceOf(MultipleValidationWithAnd::class))->andReturn(false);
        $egulias->shouldReceive('isValid')->with('test@example.com', anInstanceOf(RFCValidation::class))->andReturn(false);
        $egulias->shouldReceive('isValid')->with('test@example.com', anInstanceOf(SpoofCheckValidation::class))->andReturn(false);
        $egulias->shouldReceive('getError')->andReturn(mock(InvalidEmail::class));

        $validator->validateFormatOnly('test@example.com');

    }
}
