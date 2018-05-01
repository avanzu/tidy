<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Requestors\Translation\Message;

interface ITranslateRequest extends IToken, ICatalogueIdentifier
{

    public function localeString();

    public function state();

}