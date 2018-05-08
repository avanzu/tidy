<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 08.05.18
 *
 */

namespace Tidy\Integration\Domain;

use Tidy\Components\DependencyInjection\Container;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Gateways\IUserGateway;

class Gateways extends Container
{
    const USERS = 'users';

    const PROJECTS = 'projects';

    const TRANSLATIONS = 'translations';

    /**
     * @var IGatewayFactory
     */
    protected $factory;

    /**
     * @var IUserGateway
     */
    protected $userGateway;

    /**
     * @var IProjectGateway
     */
    protected $projectGateway;

    /**
     * @var ITranslationGateway
     */
    protected $translationGateway;

    public function __construct(IGatewayFactory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @return IUserGateway
     */
    public function users()
    {
        if (!$this->contains(self::USERS)) {
            $this->attach(self::USERS, $this->factory->makeUserGateway());
        }

        return $this->reveal(self::USERS);

    }

    /**
     * @return IProjectGateway
     */
    public function projects()
    {
        if (!$this->contains(self::PROJECTS)) {
            $this->attach(self::PROJECTS, $this->factory->makeProjectGateway());
        }

        return $this->reveal(self::PROJECTS);

    }

    /**
     * @return ITranslationGateway
     */
    public function translations()
    {
        if (!$this->contains(self::TRANSLATIONS)) {
            $this->attach(self::TRANSLATIONS, $this->factory->makeTranslationGateway());
        }

        return $this->reveal(self::TRANSLATIONS);

    }


}