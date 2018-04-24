<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 24.04.18
 *
 */
namespace Tidy\Domain\Responders\Project;

interface IExcerpt
{
    public function getName();

    /**
     * @return mixed
     */
    public function getCanonical();

    public function getId();
}