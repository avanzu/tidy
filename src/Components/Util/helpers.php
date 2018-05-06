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