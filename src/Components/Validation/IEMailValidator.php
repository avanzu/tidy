<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Validation;

interface IEMailValidator extends IValidator
{

    /**
     * @param  $value
     * @return boolean
     */
    public function validateFormatOnly($value);

    /**
     * @param $value
     *
     * @return boolean
     */
    public function validateFormatWithSpoofCheck($value);

    /**
     * @return ErrorList
     */
    public function violations();
}