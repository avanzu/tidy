<?php
/**
 * GetUserCollectionRequestBuilder.php
 * tidy
 * Date: 07.04.18
 */

namespace Tidy\UseCases\User\DTO;

use Tidy\Requestors\CollectionRequest;


/**
 * Class GetUserCollectionRequestBuilder
 */
class GetUserCollectionRequestBuilder
{
    /**
     * @var GetUserCollectionRequestDTO
     */
    private $request;


    /**
     * @return $this
     */
    public function create()
    {
        $request           = new GetUserCollectionRequestDTO();
        $request->page     = CollectionRequest::DEFAULT_PAGE;
        $request->pageSize = CollectionRequest::DEFAULT_PAGE_SIZE;
        $this->request     = $request;

        return $this;
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
     * @return GetUserCollectionRequestDTO
     */
    public function build()
    {
        return $this->getRequest();
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