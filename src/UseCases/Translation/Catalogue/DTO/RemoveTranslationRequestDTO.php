<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

use Tidy\Domain\Requestors\Translation\Message\IRemoveTranslationRequest;

class RemoveTranslationRequestDTO implements IRemoveTranslationRequest
{
    protected $catalogueId;

    protected $token;

    /**
     * RemoveTranslationRequestDTO constructor.
     *
     * @param $catalogueId
     * @param $token
     */
    public function __construct($catalogueId, $token)
    {
        $this->catalogueId = $catalogueId;
        $this->token       = $token;
    }


    public function catalogueId()
    {
        return $this->catalogueId;
    }

    public function token()
    {
        return $this->token;
    }
}