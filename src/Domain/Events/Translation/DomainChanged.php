<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\Events\Translation;

use Tidy\Domain\Entities\TranslationDomain;

class DomainChanged extends Event
{
    /**
     * @var TranslationDomain
     */
    protected $domain;

    public function __construct($id, TranslationDomain $domain)
    {
        parent::__construct($id);
        $this->domain = $domain;
    }

    /**
     * @return TranslationDomain
     */
    public function domain()
    {
        return $this->domain;
    }




}