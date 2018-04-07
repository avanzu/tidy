<?php
/**
 * GetUserCollectionRequestBuilder.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Requestors\ICollectionRequest;
use Tidy\Requestors\User\IGetUserCollectionRequestBuilder;


/**
 * Class GetUserCollectionRequestBuilder
 */
class GetUserCollectionRequestBuilder implements IGetUserCollectionRequestBuilder
{
    /**
     * @var GetUserCollectionRequestDTO
     */
    private $request;

    /**
     * @return \Tidy\Requestors\User\IGetUserCollectionRequest|GetUserCollectionRequestDTO
     */
    public function build()
    {
        return $this->getRequest();
    }

    /**
     * @return GetUserCollectionRequestDTO
     */
    private function getRequest()
    {
        if (!$this->request) {
            $this->create();
        }

        return $this->request;
    }

    /**
     * @return $this
     */
    public function create()
    {
        $request           = new GetUserCollectionRequestDTO();
        $request->page     = ICollectionRequest::DEFAULT_PAGE;
        $request->pageSize = ICollectionRequest::DEFAULT_PAGE_SIZE;
        $this->request     = $request;

        return $this;
    }

    /**
     * @param $page
     *
     * @return $this
     */
    public function fromPage($page)
    {
        $this->getRequest()->page = $page;

        return $this;
    }

    /**
     * @param $pageSize
     *
     * @return $this
     */
    public function withPageSize($pageSize)
    {
        $this->getRequest()->pageSize = $pageSize;

        return $this;
    }
}