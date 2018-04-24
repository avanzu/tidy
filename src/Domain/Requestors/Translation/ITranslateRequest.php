<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation;

interface ITranslateRequest
{
    /**
     * @param $id
     *
     * @return ITranslateRequest
     */
    public function withCatalogueId($id);

    /**
     * @param $token
     *
     * @return ITranslateRequest
     */
    public function withToken($token);

    /**
     * @param $localeString
     *
     * @return ITranslateRequest
     */
    public function translateAs($localeString);

    /**
     * @param $string
     *
     * @return ITranslateRequest
     */
    public function commitStateTo($string);

    public function localeString();

    public function state();

    public function catalogueId();

    public function token();
}