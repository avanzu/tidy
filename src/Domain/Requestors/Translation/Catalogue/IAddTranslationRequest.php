<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation\Catalogue;

interface IAddTranslationRequest
{
    /**
     * @param $string
     *
     * @return IAddTranslationRequest
     */
    public function withSourceString($string);

    /**
     * @param $string
     *
     * @return IAddTranslationRequest
     */
    public function withLocaleString($string);

    /**
     * @param $ID
     *
     * @return IAddTranslationRequest
     */
    public function withCatalogueId($ID);

    /**
     * @param $string
     *
     * @return IAddTranslationRequest
     */
    public function withMeaning($string);

    /**
     * @param $string
     *
     * @return IAddTranslationRequest
     */
    public function withNotes($string);

    /**
     * @param $state
     *
     * @return IAddTranslationRequest
     */
    public function withState($state);

    public function catalogueId();

    public function sourceString();

    public function localeString();

    public function meaning();

    public function notes();

    public function state();

    /**
     * @param $token
     *
     * @return IAddTranslationRequest
     */
    public function withToken($token);

    public function token();
}