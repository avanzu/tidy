<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Tests\Unit\Components\Validation;

use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Components\Validation\Validators\PasswordStrengthValidator;
use Tidy\Tests\MockeryTestCase;

class PasswordStrengthValidatorTest extends MockeryTestCase
{
    public function test_moderate()
    {
        $validator = new PasswordStrengthValidator();
        assertThat($validator->validate(''), is(false));
        assertThat($validator->violations()->atIndex('minLength'),is(
            allOf(nonEmptyString(), containsString('6'))
        ));
        assertThat($validator->violations()->atIndex('letters'),is(nonEmptyString()));
        assertThat($validator->violations()->atIndex('numbers'),is(nonEmptyString()));
    }
    public function test_strong()
    {
        $validator = new PasswordStrengthValidator(IPasswordStrengthValidator::STRENGTH_STRONG);
        assertThat($validator->validate(''), is(false));
        assertThat($validator->violations()->atIndex('minLength'),is(
            allOf(nonEmptyString(), containsString('8'))
        ));
        assertThat($validator->violations()->atIndex('letters'),is(nonEmptyString()));
        assertThat($validator->violations()->atIndex('numbers'),is(nonEmptyString()));
        assertThat($validator->violations()->atIndex('capitals'),is(nonEmptyString()));
        assertThat($validator->violations()->atIndex('specialChrs'),is(nonEmptyString()));
    }

    public function test_paranoid()
    {
        $validator = new PasswordStrengthValidator(IPasswordStrengthValidator::STRENGTH_PARANOID);
        assertThat($validator->validate('password'), is(false));

        assertThat($validator->violations()->atIndex('minLength'),is(
            allOf(nonEmptyString(), containsString('10'))
        ));

        assertThat($validator->violations()->atIndex('numbers'),is(nonEmptyString()));
        assertThat($validator->violations()->atIndex('capitals'),is(nonEmptyString()));
        assertThat($validator->violations()->atIndex('specialChrs'),is(nonEmptyString()));
        assertThat($validator->violations()->atIndex('blacklist'),is(nonEmptyString()));
    }

}