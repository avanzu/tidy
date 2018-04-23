<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 23.04.18
 *
 */

namespace Tidy\UseCases\Translation;

use Tidy\Components\Audit\Change;
use Tidy\Components\Audit\ChangeSet;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\UseCases\Translation\DTO\ChangeResponseTransformer;
use Tidy\UseCases\Translation\DTO\TranslateRequestDTO;

class Translate
{
    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * @var ChangeResponseTransformer
     */
    protected $transformer;

    /**
     * Translate constructor.
     *
     * @param ITranslationGateway            $gateway
     * @param ChangeResponseTransformer|null $transformer
     */
    public function __construct(ITranslationGateway $gateway, ChangeResponseTransformer $transformer = null)
    {
        $this->gateway     = $gateway;
        $this->transformer = $transformer;
    }

    public function execute(TranslateRequestDTO $request)
    {

        $catalogue   = $this->gateway->findCatalogue($request->catalogueId());
        $translation = $catalogue->find($request->token());
        $path        = $catalogue->path();
        $changes     = ChangeSet::make()
                                ->add($this->replaceLocaleString($request, $translation, $path))
                                ->add($this->replaceState($request, $translation, $path))
        ;

        if( count($changes)) $this->gateway->save($catalogue);

        return $this->transformer()->transform($changes);
    }


    protected function transformer()
    {
        if (!$this->transformer) {
            $this->transformer = new ChangeResponseTransformer();
        }

        return $this->transformer;
    }

    /**
     * @param TranslateRequestDTO $request
     * @param Translation         $translation
     * @param                     $path
     *
     * @return null|Change
     */
    protected function replaceLocaleString(TranslateRequestDTO $request, Translation $translation, $path)
    {
        if (!$request->localeString()) {
            return null;
        }

        $translation->setLocaleString($request->localeString());
        return Change::replace($request->localeString(),$this->pathTo($translation, $path, 'localeString'));
    }

    /**
     * @param TranslateRequestDTO $request
     * @param Translation         $translation
     * @param                     $path
     *
     * @return null|Change
     */
    protected function replaceState(TranslateRequestDTO $request, Translation $translation, $path)
    {
        if (!$request->state()) {
            return null;
        }
        $translation->setState($request->state());
        return Change::replace($request->state(),$this->pathTo($translation, $path, 'state'));
    }

    /**
     * @param Translation $translation
     * @param             $path
     *
     * @param             $attribute
     *
     * @return string
     */
    protected function pathTo(Translation $translation, $path, $attribute)
    {
        return sprintf('%s/%s/%s', $path, $translation->getToken(), $attribute);
    }

}