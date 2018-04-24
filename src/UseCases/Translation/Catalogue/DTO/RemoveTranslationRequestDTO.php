<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */

namespace Tidy\UseCases\Translation\Catalogue\DTO;

class RemoveTranslationRequestDTO
{
    public $catalogueId;

    public $token;

    /**
     * @return RemoveTranslationRequestDTO
     */
    public static function make()
    {
        return new static;
    }

    /**
     * @param $catalogueId
     *
     * @return RemoveTranslationRequestDTO
     */
    public function withCatalogueId($catalogueId)
    {
        $this->catalogueId = $catalogueId;

        return $this;
    }

    /**
     * @param $token
     *
     * @return RemoveTranslationRequestDTO
     */
    public function withToken($token)
    {
        $this->token = $token;

        return $this;
    }

    public function catalogueId() {
        return $this->catalogueId;
    }

    public function token() {
        return $this->token;
    }
}