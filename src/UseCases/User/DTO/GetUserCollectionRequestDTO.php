<?php
/**
 * GetUserCollectionRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;


use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\User\IGetUserCollectionRequest;

/**
 * Class GetUserCollectionRequestDTO
 */
class GetUserCollectionRequestDTO extends CollectionRequest implements IGetUserCollectionRequest
{
    public $userName;
    public $eMail;
    public $enabled;
    public $token;
    public $firstName;
    public $lastName;


    public $criteria = [];

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return static
     */
    public static function make($page = CollectionRequest::DEFAULT_PAGE, $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE)
    {
        return new static($page, $pageSize);
    }

    /**
     * @param Comparison $comparison
     *
     * @return $this
     */
    public function withUserName(Comparison $comparison = null)
    {
        $this->criteria['userName'] = $comparison;

        return $this;
    }

    public function withEMail(Comparison $comparison = null)
    {
        $this->criteria['eMail'] = $comparison;

        return $this;
    }

    public function withAccess(Comparison $comparison = null)
    {
        $this->criteria['enabled'] = $comparison;

        return $this;
    }

    public function withToken(Comparison $comparison = null)
    {
        $this->criteria['token'] = $comparison;

        return $this;
    }

    public function withFirstName(Comparison $comparison = null)
    {
        $this->criteria['firstName'] = $comparison;

        return $this;
    }

    public function withLastName(Comparison $comparison = null)
    {
        $this->criteria['lastName'] = $comparison;

        return $this;
    }

    public function getCriteria()
    {
        return array_filter($this->criteria);
    }


}