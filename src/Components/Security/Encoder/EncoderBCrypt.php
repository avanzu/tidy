<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 01.05.18
 *
 */

namespace Tidy\Components\Security\Encoder;

class EncoderBCrypt implements IPasswordEncoder
{

    /**
     * @param $plain
     * @param $salt
     *
     * @return string
     */
    public function encode($plain, $salt)
    {
        return password_hash($plain, PASSWORD_BCRYPT);
    }
}