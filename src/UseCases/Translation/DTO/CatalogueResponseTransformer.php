<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\UseCases\Translation\DTO;

use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Responders\Project\IExcerptTransformer;
use Tidy\Domain\Responders\Translation\ICatalogueResponseTransformer;
use Tidy\UseCases\Project\DTO\ExcerptTransformer;

class CatalogueResponseTransformer implements ICatalogueResponseTransformer
{

    /**
     * @var IExcerptTransformer
     */
    protected $excerptTransformer;

    /**
     * CatalogueResponseTransformer constructor.
     *
     * @param IExcerptTransformer $projectTransformer
     */
    public function __construct(IExcerptTransformer $projectTransformer = null)
    {
        $this->excerptTransformer = $projectTransformer;
    }

    public function swapExcerptTransformer($transformer) {
        $previous = $this->excerptTransformer;
        $this->excerptTransformer = $transformer;
        return $previous;
    }

    protected function excerptTransformer()
    {
        if( ! $this->excerptTransformer) $this->excerptTransformer = new ExcerptTransformer();
        return $this->excerptTransformer;
    }

    public function transform(TranslationCatalogue $catalogue)
    {
        $response                 = new CatalogueResponseDTO();
        $response->id             = $catalogue->getId();
        $response->canonical      = $catalogue->getCanonical();
        $response->name           = $catalogue->getName();
        $response->sourceLanguage = $catalogue->getSourceLanguage();
        $response->sourceCulture  = $catalogue->getSourceCulture();
        $response->targetLanguage = $catalogue->getTargetLanguage();
        $response->targetCulture  = $catalogue->getTargetCulture();
        $response->project        = $this->makeProjectExcerpt($catalogue);

        return $response;
    }

    /**
     * @param TranslationCatalogue $catalogue
     */
    protected function makeProjectExcerpt(TranslationCatalogue $catalogue)
    {
        if( $project =  $catalogue->getProject() )
            return $this->excerptTransformer()->excerpt($project);
        return null;
    }
}