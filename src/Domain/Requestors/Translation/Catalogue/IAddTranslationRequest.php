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

    public function catalogueId();

    public function sourceString();

    public function localeString();

    public function meaning();

    public function notes();

    public function state();

    public function token();
}