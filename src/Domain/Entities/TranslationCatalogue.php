<?php
/**
 * This file is part of the Tidy Project.
 *
 * TranslationCatalogue.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\Domain\Entities;

use ArrayObject;
use Tidy\Components\Collection\HashMap;
use Tidy\Components\Events\IMessenger;
use Tidy\Components\Events\TMessenger;
use Tidy\Components\Exceptions\InvalidArgument;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Events\Translation\Created;
use Tidy\Domain\Events\Translation\Described;
use Tidy\Domain\Events\Translation\DomainChanged;
use Tidy\Domain\Events\Translation\Removed;
use Tidy\Domain\Events\Translation\SetUp;
use Tidy\Domain\Events\Translation\Translated;
use Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest;
use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;
use Tidy\Domain\Requestors\Translation\Message\IRemoveTranslationRequest;
use Tidy\Domain\Requestors\Translation\Message\ITranslateRequest;
use Tidy\UseCases\Translation\Message\DTO\DescribeRequestDTO;

/**
 * Class TranslationCatalogue
 */
abstract class TranslationCatalogue implements IMessenger
{
    use TMessenger;

    /**
     * @var string
     */
    protected $sourceLanguage;

    /**
     * @var string
     */
    protected $sourceCulture;

    /**
     * @var string
     */
    protected $targetLanguage;

    /**
     * @var string
     */
    protected $targetCulture;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $canonical;

    /**
     * @var Translation[]|ArrayObject
     */
    protected $translations;

    /**
     * @var Project
     */
    protected $project;

    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * @return Project
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * @param Project $project
     *
     * @return $this
     * @todo replace this by actual transaction
     */
    public function setProject($project)
    {
        $this->project = $project;

        return $this;
    }


    /**
     * @return mixed
     */
    public function getSourceLanguage()
    {
        return $this->sourceLanguage;
    }


    /**
     * @return mixed
     */
    public function getSourceCulture()
    {
        return $this->sourceCulture;
    }


    /**
     * @return mixed
     */
    public function getTargetLanguage()
    {
        return $this->targetLanguage;
    }


    /**
     * @return mixed
     */
    public function getTargetCulture()
    {
        return $this->targetCulture;
    }


    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getCanonical()
    {
        return $this->canonical;
    }

    /**
     * @return string
     */
    public function sourceLocale()
    {
        return implode('-', array_filter([$this->getSourceLanguage(), $this->getSourceCulture()]));
    }

    /**
     * @return string
     */
    public function targetLocale()
    {
        return implode('-', array_filter([$this->getTargetLanguage(), $this->getTargetCulture()]));
    }

    public function appendTranslation(IAddTranslationRequest $request, TranslationRules $rules)
    {
        $rules->verifyAppend($request, $this);

        $translation = $this->deposit(
            $this->makeTranslation(
                $request->token(),
                $request->sourceString(),
                $request->localeString(),
                $request->meaning(),
                $request->notes(),
                $request->state()
            )
        );

        $this->queueEvent(new Created($this->id, $translation));

        return $translation;

    }

    public function removeTranslation(IRemoveTranslationRequest $request, TranslationRules $rules)
    {
        $rules->verifyRemoveTranslation($request, $this);
        $match = $this->find($request->token());
        $this->translations()->offsetUnset($request->token());
        $this->queueEvent(new Removed($this->id, $match));

        return $match;

    }

    /**
     * @param $token
     *
     * @return Translation|null
     */
    public function find($token)
    {
        return $this->translations()->atIndex($token);
    }

    /**
     * @param callable $callback
     *
     * @return array
     */
    public function map(callable $callback)
    {
        return array_map($callback, $this->translations()->getArrayCopy());
    }

    /**
     * @param      $language
     * @param null $culture
     *
     * @return $this
     */
    public function defineSourceLocale($language, $culture = null)
    {
        $this->enforceLanguageFormat($language);

        $this->sourceLanguage = strtolower($language);
        $this->sourceCulture  = strtoupper((string)$culture);

        $this->queueEvent(new DomainChanged($this->id, $this->identifyDomain()));

        return $this;
    }

    /**
     * @param      $language
     * @param null $culture
     *
     * @return $this
     */
    public function defineTargetLocale($language, $culture = null)
    {
        $this->enforceLanguageFormat($language);

        $this->targetLanguage = strtolower($language);
        $this->targetCulture  = strtoupper($culture);
        $this->queueEvent(new DomainChanged($this->id, $this->identifyDomain()));

        return $this;
    }

    public function identifyDomain()
    {
        return $this->makeDomain(
            (string)$this->canonical,
            (string)$this->sourceLanguage,
            (string)$this->sourceCulture,
            (string)$this->targetLanguage,
            (string)$this->targetCulture
        );
    }

    public function setUp(ICreateCatalogueRequest $request, TranslationRules $rules)
    {
        $rules->verifySetUp($request, $this);

        $this->id             = coalesce($this->id, uuid());
        $this->name           = $request->name();
        $this->canonical      = $request->canonical();
        $this->sourceLanguage = $request->sourceLanguage();
        $this->sourceCulture  = $request->sourceCulture();
        $this->targetLanguage = $request->targetLanguage();
        $this->targetCulture  = $request->targetCulture();

        $this->queueEvent(new SetUp($this->id));
    }


    public function translate(ITranslateRequest $request, TranslationRules $rules)
    {
        $rules->verifyTranslate($request, $this);
        $match = $this->find($request->token());

        $translation = $this->deposit(
            $this->makeTranslation(
                $request->token(),
                $match->getSourceString(),
                $request->localeString(),
                $match->getMeaning(),
                $match->getNotes(),
                $this->identifyState($request, $match)
            )
        );

        $this->queueEvent(new Translated($this->id, $translation));

        return $translation;
    }

    public function describe(DescribeRequestDTO $request, TranslationRules $rules)
    {
        $rules->verifyDescribe($request, $this);

        $match       = $this->find($request->token());
        $translation = $this->deposit(
            $this->makeTranslation(
                $request->token(),
                coalesce($request->sourceString(), $match->getSourceString()),
                $match->getLocaleString(),
                coalesce($request->meaning(), $match->getMeaning()),
                coalesce($request->notes(), $match->getNotes()),
                $match->getState()
            )
        );

        $this->queueEvent(new Described($this->id, $translation));

        return $translation;
    }

    /**
     * @param $match
     *
     * @return bool
     */
    public function isIdenticalTo($match)
    {
        return ($match instanceof TranslationCatalogue) ? $match->getId() === $this->getId() : false;
    }

    /**
     * @param $canonical
     * @param $sourceLanguage
     * @param $sourceCulture
     * @param $targetLanguage
     * @param $targetCulture
     *
     * @return TranslationDomain
     */
    public function makeDomain($canonical, $sourceLanguage, $sourceCulture, $targetLanguage, $targetCulture)
    {
        return new TranslationDomain($canonical, $sourceLanguage, $sourceCulture, $targetLanguage, $targetCulture);
    }

    /**
     * @return HashMap|Translation[]
     */
    protected function translations()
    {
        if (!$this->translations) {
            $this->translations = new HashMap();
        }

        return $this->translations;
    }


    /**
     * @param $language
     */
    private function enforceLanguageFormat($language)
    {
        if (strlen((string)$language) !== 2) {
            throw new InvalidArgument(sprintf('Expected 2 character string, got "%s".', $language));
        }
    }

    /**
     * @param $token
     * @param $sourceString
     * @param $localeString
     * @param $meaning
     * @param $notes
     * @param $state
     *
     * @return Translation
     */
    abstract protected function makeTranslation($token, $sourceString, $localeString, $meaning, $notes, $state);


    /**
     * @param ITranslateRequest $request
     * @param                   $match
     *
     * @return mixed
     */
    protected function identifyState(ITranslateRequest $request, Translation $match)
    {
        if ($request->state()) {
            return $request->state();
        }
        if ('new' === $match->getState()) {
            if ($match->getSourceString() !== $request->localeString()) {
                return 'translated';
            }
        }

        return $match->getState();

    }

    /**
     * @param Translation $translation
     *
     * @return Translation
     */
    private function deposit($translation)
    {
        $this->translations()->offsetSet($translation->getToken(), $translation);

        return $translation;
    }
}