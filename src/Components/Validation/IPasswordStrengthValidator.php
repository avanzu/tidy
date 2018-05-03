<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Validation;

interface IPasswordStrengthValidator extends IValidator
{

    public const STRENGTH_STRONG   = 2;
    public const STRENGTH_PARANOID = 3;
    public const STRENGTH_MODERATE = 1;

    /**
     * @return ErrorList
     */
    public function violations();
}