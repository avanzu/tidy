<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Domain\Gateways;

use Tidy\Components\Events\IDispatcher;
use Tidy\Components\Events\TBroadcast;
use Tidy\Domain\Entities\TranslationCatalogue;

abstract class TranslationGateway implements ITranslationGateway
{
    use TBroadcast;

    /**
     * UserGateway constructor.
     *
     * @param IDispatcher $dispatcher
     */
    public function __construct(IDispatcher $dispatcher)
    {
        $this->dispatcher = $dispatcher;
    }

    /**
     * @param TranslationCatalogue $catalogue
     *
     * @return mixed|void
     */
    public function save(TranslationCatalogue $catalogue)
    {
        $this->doSave($catalogue);
        $this->broadcast($catalogue);
    }



    abstract protected function doSave(TranslationCatalogue $catalogue);
}