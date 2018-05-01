<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Validation\Validators;

use acurrieclark\PhpPasswordVerifier\Verifier;
use Tidy\Components\Validation\ErrorList;
use Tidy\Components\Validation\IPasswordStrengthValidator;

class PasswordStrengthValidator implements IPasswordStrengthValidator
{

    protected $violations;

    private   $strength;

    public function __construct($strength = self::STRENGTH_MODERATE)
    {
        $this->strength   = $strength;
        $this->violations = new ErrorList();
    }

    public function validate($subject, $rules = [])
    {
        $verifier         = $this->configureVerifier(new Verifier());
        $valid            = $verifier->checkPassword($subject);
        $this->violations = new ErrorList($verifier->getErrors());
        return $valid;
    }

    /**
     * @return ErrorList
     */
    public function violations()
    {
        return $this->violations;
    }

    protected function configureVerifier(Verifier $verifier)
    {
        $verifier->setMaxLength(200)
                 ->setMinLength(6)
                 ->setCheckContainsLetters(true)
                 ->setCheckContainsNumbers(true)
        ;

        if ($this->strength > self::STRENGTH_MODERATE) {
            $verifier->setMinLength(8)->setCheckContainsCapitals(true)->setCheckContainsSpecialChrs(true);
        }

        if ($this->strength > self::STRENGTH_STRONG) {
            $verifier->setMinLength(10)->setCheckBlacklist(true);
        }

        return $verifier;
    }
}