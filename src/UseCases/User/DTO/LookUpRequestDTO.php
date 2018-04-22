<?php
/**
 * LookUpRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Domain\Requestors\User\ILookUpRequest;

/**
 * Class LookUpRequestDTO
 */
class LookUpRequestDTO implements ILookUpRequest
{

    /**
     * @var
     */
    public $userId;

    /**
     * @return int
     */
    public function userId()
    {
        return $this->userId;
    }

    /**
     * @return LookUpRequestDTO
     */
    public static function make()
    {
        return new static;
    }

    /**
     * @param $userId
     *
     * @return $this
     */
    public function withUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }
}