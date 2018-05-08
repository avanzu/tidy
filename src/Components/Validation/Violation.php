<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Components\Validation;

class Violation
{
    protected $message;

    protected $params = [];

    /**
     * Violation constructor.
     *
     * @param       $message
     * @param array $params
     */
    public function __construct($message, array $params = [])
    {
        $this->message = $message;
        $this->params  = $params;
    }


    public function message()
    {
        return (string)$this->message;
    }

    public function params() {
        return $this->params;
    }

    public function __toString()
    {
        return strtr($this->message(), $this->params());
    }

}