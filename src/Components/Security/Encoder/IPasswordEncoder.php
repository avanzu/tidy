<?php
/**
 * IPasswordEncoder.php
 * Tidy
 * Date: 14.04.18
 */

namespace Tidy\Components\Security\Encoder;


interface IPasswordEncoder
{
    /**
     * @param $plain
     * @param $salt
     *
     * @return string
     */
    public function encode($plain, $salt);
}