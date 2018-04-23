<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\UseCases\Translation\DTO\ChangeResponseDTO;
use Tidy\UseCases\Translation\DTO\TranslateRequestDTO;

class Translate
{
    protected $gateway;

    /**
     * Translate constructor.
     *
     * @param $gateway
     */
    public function __construct($gateway) {
        $this->gateway = $gateway;
    }

    public function execute(TranslateRequestDTO $request) {



        return new ChangeResponseDTO();
    }


}