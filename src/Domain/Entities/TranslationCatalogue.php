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
use Tidy\Components\Exceptions\InvalidArgument;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Validation\ErrorList;
use Tidy\Domain\Collections\TranslationCatalogues;
use Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest;
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

    public function appendTranslation(IAddTranslationRequest $request)
    {
        $this->verifyAppend($request);

        $translation = $this->makeTranslation(
            $request->token(),
            $request->sourceString(),
            $request->localeString(),
            $request->meaning(),
            $request->notes(),
            $request->state()
        );

        $this->translations()->offsetSet($translation->getToken(), $translation);

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

    public function identifyDomain()
    {
        return $this->makeDomain(
            $this->canonical,
            $this->sourceLanguage,
            $this->sourceCulture,
            $this->targetLanguage,
            $this->targetCulture
        );
    }

    public function setUp(ICreateCatalogueRequest $request, TranslationCatalogues $catalogues)
    {

        $this->verifySetup($request, $catalogues);

        $this->name           = $request->name();
        $this->canonical      = $request->canonical();
        $this->sourceLanguage = $request->sourceLanguage();
        $this->sourceCulture  = $request->sourceCulture();
        $this->targetLanguage = $request->targetLanguage();
        $this->targetCulture  = $request->targetCulture();
    }

    public function __toString()
    {
        return (string)$this->name;
    }

    /**
     * @param $match
     *
     * @return bool
     */
    protected function isIdenticalTo($match)
    {
        return ($match instanceof TranslationCatalogue) ? $match->getId() === $this->getId() : false;
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
     * @param $canonical
     * @param $sourceLanguage
     * @param $sourceCulture
     * @param $targetLanguage
     * @param $targetCulture
     *
     * @return TranslationDomain
     */
    protected function makeDomain($canonical, $sourceLanguage, $sourceCulture, $targetLanguage, $targetCulture)
    {
        return new TranslationDomain($canonical, $sourceLanguage, $sourceCulture, $targetLanguage, $targetCulture);
    }

    protected function verifySetup(ICreateCatalogueRequest $request, TranslationCatalogues $catalogues)
    {

        $errors = new ArrayObject();

        $errors = $this->verifyName($request, $errors);
        $errors = $this->verifyCanonical($request, $errors);
        $errors = $this->verifySourceLanguage($request, $errors);
        $errors = $this->verifyTargetLanguage($request, $errors);
        $this->failOnErrors($errors);

        $errors = $this->verifyDomain($request, $catalogues, $errors);
        $this->failOnErrors($errors);
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

    /**
     * @param ICreateCatalogueRequest $request
     * @param TranslationCatalogues   $catalogues
     * @param                         $errors
     *
     * @return mixed
     */
    protected function verifyDomain(ICreateCatalogueRequest $request, TranslationCatalogues $catalogues, $errors)
    {
        $domain = $this->makeDomain(
            $request->canonical(),
            $request->sourceLanguage(),
            $request->sourceCulture(),
            $request->targetLanguage(),
            $request->targetCulture()
        );

        if ($match = $catalogues->findByDomain($domain)) {
            if (!$this->isIdenticalTo($match)) {
                $errors['domain'] = sprintf(
                    'Invalid domain "%s". Already in use by "%s".',
                    (string)$domain,
                    (string)$match
                );
            }
        }

        return $errors;
    }

    /**
     * @param ICreateCatalogueRequest $request
     * @param                         $errors
     *
     * @return mixed
     */
    protected function verifyName(ICreateCatalogueRequest $request, $errors)
    {
        if (strlen($request->name()) < 3) {
            $errors['name'] = sprintf('Invalid name "%s". Name must contain at least 3 characters.', $request->name());
        }

        return $errors;
    }

    /**
     * @param ICreateCatalogueRequest $request
     * @param                         $errors
     *
     * @return mixed
     */
    protected function verifyCanonical(ICreateCatalogueRequest $request, $errors)
    {
        if (strlen($request->canonical()) < 3) {
            $errors['canonical'] = sprintf(
                'Invalid canonical "%s". Canonical must contain at least 3 characters.',
                $request->canonical()
            );
        }

        return $errors;
    }

    /**
     * @param ICreateCatalogueRequest $request
     * @param                         $errors
     *
     * @return mixed
     */
    protected function verifySourceLanguage(ICreateCatalogueRequest $request, $errors)
    {
        if (strlen((string)$request->sourceLanguage()) !== 2) {
            $errors['sourceLanguage'] = sprintf(
                'Invalid source language. Expected 2 character string, got "%s".',
                (string)$request->sourceLanguage()
            );
        }

        return $errors;
    }

    /**
     * @param ICreateCatalogueRequest $request
     * @param                         $errors
     *
     * @return mixed
     */
    protected function verifyTargetLanguage(ICreateCatalogueRequest $request, $errors)
    {
        if (strlen((string)$request->targetLanguage()) !== 2) {
            $errors['targetLanguage'] = sprintf(
                'Invalid target language. Expected 2 character string, got "%s".',
                (string)$request->targetLanguage()
            );
        }

        return $errors;
    }

    /**
     * @param $errors
     */
    protected function failOnErrors(ArrayObject $errors)
    {
        if ($errors->count() > 0) {
            throw new PreconditionFailed($errors->getArrayCopy());
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

    protected function verifyAppend(IAddTranslationRequest $request)
    {
        $errors = new ErrorList();
        $errors = $this->verifyToken($request->token(), $errors);
        $errors = $this->verifyTokenIsUnique($request->token(), $errors);

        $this->failOnErrors($errors);
    }

    /**
     * @param                        $value
     * @param                        $errors
     *
     * @return mixed
     */
    protected function verifyTokenIsUnique($value, $errors)
    {
        /** @var Translation|null $match */
        if ($match = $this->translations()->atIndex($value)) {
            $errors['token'] = sprintf('Token %s already exists translated as "%s".', $value, (string)$match);
        }

        return $errors;
    }

    /**
     * @param                        $value
     * @param                        $errors
     *
     * @return mixed
     */
    protected function verifyToken($value, $errors)
    {
        if (empty($value)) {
            $errors['token'] = 'Token cannot be empty.';
        }

        return $errors;
    }
}