<?php
/**
 * IOwnerExcerpt.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Domain\Responders\AccessControl;

interface IOwnerExcerpt
{
    /**
     * @return int
     */
    public function getIdentity();

    /**
     * @return string
     */
    public function getName();
}