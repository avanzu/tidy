<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 25.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

class RemoveTranslationRequestBuilder
{

    protected $catalogueId;

    protected $token;

    /**
     * @param $catalogueId
     *
     * @return $this
     */
    public function withCatalogueId($catalogueId)
    {
        $this->catalogueId = $catalogueId;

        return $this;
    }

    /**
     * @param $token
     *
     * @return $this
     */
    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function build()
    {
        return new RemoveTranslationRequestDTO($this->catalogueId, $this->token);
    }
}