<?php
/**
 * This file is part of the Tidy Project.
 *
 * TranslationCatalogue.php Created by avanzu on 22.04.18 with PhpStorm.
 *
 */

namespace Tidy\Domain\Entities;

use ArrayObject;
use Tidy\Components\Exceptions\InvalidArgument;
use Tidy\Components\Exceptions\LanguageIsEmpty;
use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;

/**
 * Class TranslationCatalogue
 */
abstract class TranslationCatalogue
{
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
     * @param mixed $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
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
     * @param mixed $canonical
     *
     * @return $this
     */
    public function setCanonical($canonical)
    {
        $this->canonical = $canonical;

        return $this;
    }


    /**
     * @return string
     */
    public function sourceLocale()
    {
        if (empty($this->getSourceLanguage())) {
            throw new LanguageIsEmpty('Source language is not defined.');
        }

        return implode('-', array_filter([$this->getSourceLanguage(), $this->getSourceCulture()]));
    }

    /**
     * @return string
     */
    public function targetLocale()
    {
        if (empty($this->getTargetLanguage())) {
            throw new LanguageIsEmpty('Target language is not defined.');
        }

        return implode('-', array_filter([$this->getTargetLanguage(), $this->getTargetCulture()]));
    }

    /**
     * @param Translation $translation
     *
     * @return $this
     */
    public function add(Translation $translation)
    {
        $this->translations()->offsetSet($translation->getToken(), $translation);

        return $this;
    }

    /**
     * @param Translation $translation
     *
     * @return $this
     */
    public function remove(Translation $translation)
    {
        if ($this->translations()->offsetExists($translation->getToken())) {
            $this->translations()->offsetUnset($translation->getToken());
        }

        return $this;
    }

    /**
     * @param $token
     *
     * @return Translation|null
     */
    public function find($token)
    {
        if ($this->translations()->offsetExists($token)) {
            return $this->translations()->offsetGet($token);
        }

        return null;
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
        $this->verifyLanguageFormat($language);

        $this->sourceLanguage = strtolower($language);
        $this->sourceCulture  = strtoupper((string)$culture);

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
        $this->verifyLanguageFormat($language);

        $this->targetLanguage = strtolower($language);
        $this->targetCulture  = strtoupper($culture);

        return $this;
    }

    public function setUp(ICreateCatalogueRequest $request)
    {
        $this->name           = $request->name();
        $this->canonical      = $request->canonical();
        $this->sourceLanguage = $request->sourceLanguage();
        $this->sourceCulture  = $request->sourceCulture();
        $this->targetLanguage = $request->targetLanguage();
        $this->targetCulture  = $request->targetCulture();
    }

    /**
     * @return ArrayObject|Translation[]
     */
    protected function translations()
    {
        if (!$this->translations) {
            $this->translations = new ArrayObject();
        }

        return $this->translations;
    }

    /**
     * @param $language
     */
    protected function verifyLanguageFormat($language)
    {
        if (strlen((string)$language) !== 2) {
            throw new InvalidArgument(sprintf('Expected 2 character string, got "%s".', $language));
        }
    }


}