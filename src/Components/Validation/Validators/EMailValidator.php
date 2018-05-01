<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Validation\Validators;

use Egulias\EmailValidator\EmailValidator as EguliasValidator;
use Egulias\EmailValidator\Exception\InvalidEmail;
use Egulias\EmailValidator\Validation\MultipleErrors;
use Egulias\EmailValidator\Validation\MultipleValidationWithAnd;
use Egulias\EmailValidator\Validation\RFCValidation;
use Egulias\EmailValidator\Validation\SpoofCheckValidation;
use Tidy\Components\Validation\ErrorList;
use Tidy\Components\Validation\IEMailValidator;

class EMailValidator implements IEMailValidator
{

    /**
     * @var EguliasValidator
     */
    protected $validator;

    /**
     * @var ErrorList
     */
    protected $violations;

    /**
     * EMailValidator constructor.
     *
     * @param EguliasValidator $validator
     */
    public function __construct(EguliasValidator $validator = null)
    {
        $this->validator  = $validator;
        $this->violations = new ErrorList();
    }


    /**
     * @param       $subject
     * @param array $rules
     *
     * @return bool
     */
    public function validate($subject, $rules = [])
    {
        return $this->validateFormatWithSpoofCheck($subject);
    }

    private function collectErrors(InvalidEmail $invalidEmail)
    {

        if( $invalidEmail instanceof MultipleErrors ) {
            foreach ($invalidEmail->getErrors() as $error) {
                $this->collectErrors($error);
            }
            return;
        }

        $this->violations->append($invalidEmail->getMessage());

    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function validateFormatOnly($value)
    {
        $this->violations = new ErrorList();
        $isValid          = $this->validator()->isValid($value, new RFCValidation());
        if (!$isValid) {
            $this->collectErrors($this->validator()->getError());
        }

        return $isValid;
    }

    /**
     * @param $value
     *
     * @return bool
     */
    public function validateFormatWithSpoofCheck($value)
    {
        $this->violations = new ErrorList();
        $validatorSet = [
            new RFCValidation(),
            new SpoofCheckValidation(),
        ];

        $isValid =  $this->validator()->isValid($value, new MultipleValidationWithAnd($validatorSet, MultipleValidationWithAnd::ALLOW_ALL_ERRORS));

        if( !$isValid ) {
            $this->collectErrors($this->validator()->getError());
        }

        return $isValid;

    }

    public function violations()
    {
        return $this->violations;
    }

    private function validator()
    {
        if (!$this->validator) {
            $this->validator = new EguliasValidator();
        }

        return $this->validator;
    }


}