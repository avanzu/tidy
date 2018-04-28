<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 28.04.18
 *
 */

namespace Tidy\UseCases\Project\DTO;

use Tidy\Components\Normalisation\ITextNormaliser;

class CreateRequestBuilder
{

    protected $name;

    protected $description;

    protected $ownerId;

    protected $canonical;

    /**
     * @var ITextNormaliser
     */
    protected $normaliser;

    /**
     * CreateRequestBuilder constructor.
     *
     * @param ITextNormaliser $normaliser
     */
    public function __construct(ITextNormaliser $normaliser) {
        $this->normaliser = $normaliser;
    }

    /**
     * @param $description
     *
     * @return $this
     */
    public function withDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @param $name
     *
     * @return $this
     */
    public function withName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @param $owner
     *
     * @return $this
     */
    public function withOwnerId($owner)
    {
        $this->ownerId = $owner;

        return $this;
    }

    public function withCanonical($canonical)
    {
        $this->canonical = $canonical;
        return $this;
    }

    public function build()
    {
        if( empty($this->canonical )) {
            $this->canonical = $this->normaliser->transform($this->name);
        }

        return new CreateRequestDTO($this->name, $this->description, $this->ownerId, $this->canonical);
    }
}