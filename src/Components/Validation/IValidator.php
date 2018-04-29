<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 29.04.18
 *
 */
namespace Tidy\Components\Validation;

interface IValidator
{
    public function validate($subject, $rules = []);
}