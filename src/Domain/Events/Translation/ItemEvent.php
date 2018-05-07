<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\Events\Translation;

use Tidy\Domain\Entities\Translation;

class ItemEvent extends Event
{
    /**
     * @var Translation
     */
    protected $translation;

    public function __construct($id, Translation $translation)
    {
        parent::__construct($id);
        $this->translation = $translation;
    }

    /**
     * @return Translation
     */
    public function translation()
    {
        return $this->translation;
    }
}