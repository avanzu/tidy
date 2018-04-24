<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Responders\Translation;

interface ITranslationResponse
{
    /**
     * @return mixed
     */
    public function getState();

    /**
     * @return mixed
     */
    public function getNotes();

    /**
     * @return mixed
     */
    public function getMeaning();

    public function getId();

    public function getSourceString();

    /**
     * @return mixed
     */
    public function getLocaleString();
}