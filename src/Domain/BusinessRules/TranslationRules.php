<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 07.05.18
 *
 */

namespace Tidy\Domain\BusinessRules;

use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Components\Validation\ErrorList;
use Tidy\Components\Validation\Violation;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Requestors\Translation\Catalogue\IAddTranslationRequest;
use Tidy\Domain\Requestors\Translation\Catalogue\ICreateCatalogueRequest;
use Tidy\Domain\Requestors\Translation\Message\ICatalogueIdentifier;
use Tidy\Domain\Requestors\Translation\Message\IRemoveTranslationRequest;
use Tidy\Domain\Requestors\Translation\Message\IToken;
use Tidy\Domain\Requestors\Translation\Message\ITranslateRequest;
use Tidy\UseCases\Translation\Message\DTO\DescribeRequestDTO;

class TranslationRules
{

    /**
     * @var ITranslationGateway
     */
    protected $gateway;

    /**
     * TranslationRules constructor.
     *
     * @param ITranslationGateway $gateway
     */
    public function __construct(ITranslationGateway $gateway)
    {
        $this->gateway = $gateway;
    }

    public function verifyAppend(IAddTranslationRequest $request, TranslationCatalogue $catalogue)
    {
        $errors = new ErrorList();
        $errors = $this->verifyToken($request->token(), $errors);
        $errors = $this->verifyTokenIsUnique($request->token(), $catalogue, $errors);

        $this->failOnErrors($errors);
    }

    public function verifyRemoveTranslation(IRemoveTranslationRequest $request, TranslationCatalogue $catalogue)
    {
        $this->verifyCatalogueId($request, $catalogue);
        $this->verifyTokenExists($request, $catalogue);

    }

    public function verifyTranslate(ITranslateRequest $request, TranslationCatalogue $catalogue)
    {
        $this->verifyCatalogueId($request, $catalogue);
        $this->verifyTokenExists($request, $catalogue);
    }

    public function verifyDescribe(DescribeRequestDTO $request, TranslationCatalogue $catalogue)
    {
        $this->verifyCatalogueId($request, $catalogue);
        $this->verifyTokenExists($request, $catalogue);
    }

    public function verifySetUp(ICreateCatalogueRequest $request, TranslationCatalogue $catalogue)
    {

        $errors = new ErrorList();

        $errors = $this->verifyName($request, $errors);
        $errors = $this->verifyCanonical($request, $errors);
        $errors = $this->verifySourceLanguage($request, $errors);
        $errors = $this->verifyTargetLanguage($request, $errors);
        $this->failOnErrors($errors);

        $errors = $this->verifyDomain($request, $catalogue, $errors);
        $this->failOnErrors($errors);
    }

    /**
     * @param ICreateCatalogueRequest $request
     * @param TranslationCatalogue    $catalogue
     * @param                         $errors
     *
     * @return mixed
     */
    protected function verifyDomain(ICreateCatalogueRequest $request, TranslationCatalogue $catalogue, $errors)
    {
        $domain = $catalogue->makeDomain(
            $request->canonical(),
            $request->sourceLanguage(),
            $request->sourceCulture(),
            $request->targetLanguage(),
            $request->targetCulture()
        );

        if ($match = $this->gateway->findByDomain($domain)) {
            if (!$catalogue->isIdenticalTo($match)) {
                $errors['domain'] = new Violation(
                    'Invalid domain "{{ domain }}". Already in use by "{{ catalogue }}".',
                    ['{{ domain }}' => (string)$domain, '{{ catalogue }}' => (string)$match]
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
            $errors['name'] = new Violation(
                'Invalid name "{{ name }}". Name must contain at least 3 characters.',
                ['{{ name }}' => $request->name()]
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
    protected function verifyCanonical(ICreateCatalogueRequest $request, $errors)
    {
        if (strlen($request->canonical()) < 3) {
            $errors['canonical'] = new Violation(
                'Invalid canonical "{{ canonical }}". Canonical must contain at least 3 characters.',
                ['{{ canonical }}' => $request->canonical()]
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
            $errors['sourceLanguage'] = new Violation(
                'Invalid source language. Expected 2 character string, got "{{ source }}".',
                ['{{ source }}' => (string)$request->sourceLanguage()]
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
            $errors['targetLanguage'] = new Violation(
                'Invalid target language. Expected 2 character string, got "{{ target }}".',
                ['{{ target }}' => (string)$request->targetLanguage()]
            );
        }

        return $errors;
    }

    /**
     * @param                        $value
     * @param TranslationCatalogue   $catalogue
     * @param                        $errors
     *
     * @return mixed
     */
    protected function verifyTokenIsUnique($value, TranslationCatalogue $catalogue, $errors)
    {
        /** @var Translation|null $match */
        if ($match = $catalogue->find($value)) {
            $errors['token'] = new Violation(
                'Token {{ token }} already exists translated as "{{ match }}".',
                ['{{ token }}' => $value, '{{ match }}' => (string)$match]
            );
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
            $errors['token'] = new Violation('Token cannot be empty.');
        }

        return $errors;
    }

    /**
     * @param ICatalogueIdentifier $request
     *
     * @param TranslationCatalogue $catalogue
     *
     * @return TranslationRules
     */
    protected function verifyCatalogueId(ICatalogueIdentifier $request, TranslationCatalogue $catalogue)
    {
        $errors = new ErrorList();
        if ($catalogue->getId() !== $request->catalogueId()) {
            $errors['catalogue'] = new Violation(
                'Wrong catalogue. Request addresses catalogue #{{ expected }}. This is catalogue #{{ actual }}.',
                ['{{ expected }}' => $request->catalogueId(), '{{ actual }}' => $catalogue->getId(),]
            );
        }

        $this->failOnErrors($errors);

        return $this;
    }

    /**
     * @param IToken               $request
     *
     * @param TranslationCatalogue $catalogue
     */
    protected function verifyTokenExists(IToken $request, TranslationCatalogue $catalogue)
    {
        $errors = new ErrorList();
        if (!$match = $catalogue->find($request->token())) {
            $errors['token'] = new Violation(
                'Unable to find translation identified by "{{ token }}" in catalogue "{{ catalogue }}".',
                ['{{ token }}' => $request->token(), '{{ catalogue }}' => $catalogue->getName()]
            );
        }

        $this->failOnErrors($errors);
    }


    /**
     * @param $errors
     */
    protected function failOnErrors(ErrorList $errors)
    {
        if ($errors->count() > 0) {
            throw new PreconditionFailed($errors->getArrayCopy());
        }
    }


}