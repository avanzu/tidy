<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 30.04.18
 *
 */

namespace Tidy\Components\Exceptions;

use Throwable;

class PreconditionFailed extends InvalidArgument
{
    /**
     * @var array
     */
    protected $errors;

    public function __construct(array $errors, string $message = "", int $code = 0, Throwable $previous = null)
    {
        parent::__construct($message,$code,$previous);
        $this->errors = $errors;
    }

    /**
     * @return mixed
     */
    public function getErrors()
    {
        return $this->errors;
    }
}