<?php
/**
 * Create.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Components\Normalisation\ITextNormaliser;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\ICreateRequest;
use Tidy\Domain\Responders\Project\IResponse;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\Domain\Responders\Project\ItemResponder;
use Tidy\UseCases\Project\Traits\TItemResponder;

class Create
{
    use TItemResponder;
    /**
     * @var ITextNormaliser
     */
    protected $normaliser;


    /**
     * Create constructor.
     *
     * @param IProjectGateway      $projectGateway
     * @param ITextNormaliser      $normaliser
     * @param IResponseTransformer $transformer
     */
    public function __construct(
        IProjectGateway $projectGateway,
        ITextNormaliser $normaliser,
        IResponseTransformer $transformer = null
    ) {
        $this->gateway  =$projectGateway;
        $this->transformer = $transformer;
        $this->normaliser = $normaliser;
    }

    /**
     * @param ICreateRequest $request
     *
     * @return IResponse
     */
    public function execute(ICreateRequest $request)
    {

        $project   = $this->gateway->makeForOwner($request->ownerId());
        $canonical = $this->normaliser->transform($request->name());
        $project
            ->setName($request->name())
            ->setDescription($request->description())
            ->setCanonical($canonical)
        ;

        $this->gateway->save($project);

        return $this->transformer()->transform($project);
    }

    public function setNormaliser($normaliser)
    {
        $this->normaliser = $normaliser;
    }

}