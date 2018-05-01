<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Tests\Unit\Components\Util;

use Tidy\Components\Normalisation\TextNormaliser;
use Tidy\Components\Util\StringUtilFactory;
use Tidy\Components\Validation\IEMailValidator;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Tests\MockeryTestCase;

class StringUtilFactoryTest extends MockeryTestCase
{


    public function test_createEncoder()
    {

        $factory = new StringUtilFactory();
        $result  = $factory->createEncoder()->encode('abc', null);
        assertThat(password_verify('abc', $result), is(true));

    }

    public function test_createNormaliser()
    {
        $factory = new StringUtilFactory();
        $string  = 'THIS IS_ ** +x some text';
        $result  = $factory->createNormaliser()->transform($string);

        assertThat($result, is(equalTo((new TextNormaliser())->transform($string))));
    }

    public function test_createEMailValidator()
    {
        $factory   = new StringUtilFactory();
        $validator = $factory->createEMailValidator();
        assertThat($validator, is(anInstanceOf(IEMailValidator::class)));

        assertThat($validator->validate('mail@avanzu.de'), is(true));
        assertThat($validator->validate('**__!!'), is(false));

    }

    public function test_createPasswordStrengthValidator()
    {
        $factory   = new StringUtilFactory();
        $validator = $factory->createPasswordStrengthValidator();

        assertThat($validator, is(anInstanceOf(IPasswordStrengthValidator::class)));

    }
}