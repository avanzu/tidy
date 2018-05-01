<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Util;

use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Components\Security\Encoder\IPasswordEncoder;
use Tidy\Components\Validation\IEMailValidator;
use Tidy\Components\Validation\IPasswordStrengthValidator;

interface IStringUtilFactory
{
    /**
     * @return IPasswordEncoder
     */
    public function createEncoder();

    /**
     * @return ITextNormaliser
     */
    public function createNormaliser();

    /**
     * @return IEMailValidator
     */
    public function createEMailValidator();

    /**
     * @param $strength
     *
     * @return IPasswordStrengthValidator
     */
    public function createPasswordStrengthValidator($strength = IPasswordStrengthValidator::STRENGTH_MODERATE);

}
