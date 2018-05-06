<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 05.05.18
 *
 */

namespace Tidy\UseCases\Translation\Message\DTO;

use Tidy\Domain\Requestors\Translation\Message\ICatalogueIdentifier;
use Tidy\Domain\Requestors\Translation\Message\IToken;

class DescribeRequestDTO implements ICatalogueIdentifier, IToken
{

    protected $catalogueId;

    protected $token;

    protected $sourceString;

    protected $meaning;

    protected $notes;

    /**
     * DescribeRequestDTO constructor.
     *
     * @param $catalogueId
     * @param $token
     * @param $sourceString
     * @param $meaning
     * @param $notes
     */
    public function __construct($catalogueId, $token, $sourceString, $meaning, $notes)
    {
        $this->catalogueId  = $catalogueId;
        $this->token        = $token;
        $this->sourceString = $sourceString;
        $this->meaning      = $meaning;
        $this->notes        = $notes;
    }


    public function catalogueId() {
        return $this->catalogueId;
    }

    public function token()
    {
        return $this->token;
    }

    public function sourceString()
    {
        return $this->sourceString;
    }

    public function meaning()
    {
        return $this->meaning;
    }

    public function notes()
    {
        return $this->notes;
    }
}