<?php
/**
 * GetCollectionRequestDTO.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Components\DataAccess\Comparison;
use Tidy\Domain\Requestors\CollectionRequest;
use Tidy\Domain\Requestors\User\IGetCollectionRequest;

/**
 * Class GetCollectionRequestDTO
 */
class GetCollectionRequestDTO extends CollectionRequest implements IGetCollectionRequest
{

    /**
     * CollectionRequest constructor.
     *
     * @param int $page
     * @param int $pageSize
     */
    public function __construct(
        $page = CollectionRequest::DEFAULT_PAGE,
        $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE
    ) {
        $this->page     = $page;
        $this->pageSize = $pageSize;
    }

    /**
     * @param int $page
     * @param int $pageSize
     *
     * @return static
     */
    public static function make(
        $page = CollectionRequest::DEFAULT_PAGE,
        $pageSize = CollectionRequest::DEFAULT_PAGE_SIZE
    ) {
        return new static($page, $pageSize);
    }

    /**
     * @param Comparison $comparison
     *
     * @return $this
     */
    public function withUserName(Comparison $comparison = null)
    {

        $this->useComparison('userName', $comparison);

        return $this;
    }

    public function withEMail(Comparison $comparison = null)
    {
        $this->useComparison('eMail', $comparison);

        return $this;
    }

    public function withAccess(Comparison $comparison = null)
    {
        $this->useComparison('enabled', $comparison);

        return $this;
    }

    public function withToken(Comparison $comparison = null)
    {
        $this->useComparison('token', $comparison);

        return $this;
    }

    public function withFirstName(Comparison $comparison = null)
    {
        $this->useComparison('firstName', $comparison);

        return $this;
    }

    public function withLastName(Comparison $comparison = null)
    {
        $this->useComparison('lastName', $comparison);

        return $this;
    }


}