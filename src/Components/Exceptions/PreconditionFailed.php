<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 30.04.18
 *
 */

namespace Tidy\Components\Exceptions;

use Throwable;
use Tidy\Components\Validation\ErrorList;

class PreconditionFailed extends InvalidArgument
{
    /**
     * @var array
     */
    protected $errors;

    public function __construct(array $errors, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
        $this->errors = new ErrorList($errors);
    }

    /**
     * @return ErrorList
     */
    public function getErrors()
    {
        return $this->errors;
    }
}