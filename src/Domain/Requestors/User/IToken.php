<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 03.05.18
 *
 */

namespace Tidy\Domain\Requestors\User;

interface IToken
{
    /** @return string */
    public function token();
}