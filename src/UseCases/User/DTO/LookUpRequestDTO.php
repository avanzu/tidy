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
    protected $userId;

    /**
     * LookUpRequestDTO constructor.
     *
     * @param $userId
     */
    public function __construct($userId) { $this->userId = $userId; }


    /**
     * @return int
     */
    public function userId()
    {
        return $this->userId;
    }
}