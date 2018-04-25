<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\Domain\Requestors;

use Tidy\Components\DataAccess\Comparison;

class CollectionRequestBuilder
{

    /**
     * @var int
     */
    protected $page;

    /**
     * @var int
     */
    protected $pageSize;


    protected $criteria = [];

    protected function useComparison($name, Comparison $comparison)
    {
        $this->criteria[$name] = $comparison;

        return $this;
    }

    public function fromPage($page)
    {
        $this->page = $page;

        return $this;
    }

    public function withPageSize($pageSize)
    {
        $this->pageSize = $pageSize;

        return $this;
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

    public function build()
    {
        return new CollectionRequest($this->page, $this->pageSize, array_filter($this->criteria));
    }

}