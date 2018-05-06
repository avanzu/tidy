<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 05.05.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

class DescribeRequestBuilder
{

    protected $catalogueId;

    protected $token;

    protected $sourceString;

    protected $meaning;

    protected $notes;

    /**
     * @param $id
     *
     * @return $this
     */
    public function withCatalogueId($id) {
        $this->catalogueId = $id;
        return $this;
    }

    public function withToken($token)
    {
        $this->token = $token;
        return $this;
    }

    public function describeAs($string)
    {
        $this->sourceString = $string;
        return $this;
    }

    public function explainWith($meaning)
    {
        $this->meaning = $meaning;
        return $this;
    }

    public function annotateWith($notes)
    {
        $this->notes = $notes;
        return $this;
    }

    public function build()
    {
        return new DescribeRequestDTO($this->catalogueId, $this->token, $this->sourceString, $this->meaning, $this->notes);
    }
}