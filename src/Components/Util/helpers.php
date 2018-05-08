<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 06.05.18
 *
 */
if (!function_exists('coalesce')) {
    /**
     * Returns the first candidate that is NOT NULL.
     * Please note that any other empty value will be considered as viable return.
     *
     * @param mixed ...$candidates
     *
     * @return mixed|null
     * @see is_null()
     * @see empty()
     */
    function coalesce(... $candidates)
    {
        foreach($candidates as $candidate){
            if (!is_null($candidate)) {
                return $candidate;
            }
        }

        return null;
    }
}

if( ! function_exists('uuid')) {
    /**
     * generates a UUID V4 string
     *
     * @return string
     */
    function uuid () {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',

            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),

            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),

            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,

            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,

            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}