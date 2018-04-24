<?php
/**
 * ProjectSilverTongue.php
 * SilverTongue
 * Date: 15.04.18
 */

namespace Tidy\Tests\Unit\Domain\Entities;

use Tidy\Domain\Entities\Project;

class ProjectSilverTongue extends Project
{
    const ID          = 9999;
    const NAME        = 'Silver Tongue';
    const CANONICAL   = 'silver-tongue';
    const DESCRIPTION = 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur luctus lacus eros. Mauris tortor lacus, condimentum nec eleifend in, aliquet ut metus. Sed varius tellus vitae nisi congue eu fringilla tellus aliquet. Nulla suscipit porttitor velit, id lobortis orci congue at. Nunc a dolor nulla. Integer quis dignissim ante. ';

    protected $id          = self::ID;

    protected $name        = self::NAME;

    protected $canonical   = self::CANONICAL;

    protected $description = self::DESCRIPTION;
}