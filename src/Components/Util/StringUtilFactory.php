<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Util;

use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Components\Normalisation\TextNormaliser;
use Tidy\Components\Security\Encoder\EncoderBCrypt;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Components\Validation\IEMailValidator;
use Tidy\Components\Validation\IPasswordStrengthValidator;
use Tidy\Components\Validation\Validators\EMailValidator;
use Tidy\Components\Validation\Validators\PasswordStrengthValidator;

class StringUtilFactory implements IStringUtilFactory
{

    /**
     * @return IEMailValidator|EMailValidator
     */
    public function createEMailValidator()
    {
        return new EMailValidator();
    }

    /**
     * @return IPasswordEncoder
     */
    public function createEncoder()
    {
        return new EncoderBCrypt();
    }

    /**
     * @return ITextNormaliser
     */
    public function createNormaliser()
    {
        return new TextNormaliser();
    }

    public function createPasswordStrengthValidator($strength = IPasswordStrengthValidator::STRENGTH_MODERATE)
    {
        return new PasswordStrengthValidator($strength);
    }

}