<?php
/**
 * Rename.php
 * Tidy
 * Date: 22.04.18
 */

namespace Tidy\UseCases\Project;

use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Requestors\Project\IRenameRequest;
use Tidy\Domain\Responders\Project\IResponseTransformer;
use Tidy\Domain\Responders\Project\ItemResponder;
use Tidy\UseCases\Project\Traits\TItemResponder;

class Rename
{
    use TItemResponder;
    /**
     * ItemResponder constructor.
     *
     * @param IProjectGateway      $projectGateway
     * @param IResponseTransformer $transformer
     */
    public function __construct(IProjectGateway $projectGateway, IResponseTransformer $transformer = null)
    {
        $this->transformer = $transformer;
        $this->gateway     = $projectGateway;
    }

    public function execute(IRenameRequest $request)
    {

        $project = $this->gateway->find($request->projectId());
        $project
            ->setName($request->name())
            ->setDescription($request->description())
        ;

        $this->gateway->save($project);

        return $this->transformer()->transform($project);
    }
}