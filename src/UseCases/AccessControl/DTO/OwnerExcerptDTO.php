<?php
/**
 * OwnerExcerptDTO.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\AccessControl\DTO;


use Tidy\Domain\Responders\AccessControl\IOwnerExcerpt;

class OwnerExcerptDTO implements IOwnerExcerpt
{
    public $identity;
    public $name;

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}