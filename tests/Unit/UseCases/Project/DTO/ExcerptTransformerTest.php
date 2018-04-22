<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Project\DTO;

use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\UseCases\Project\DTO\ExcerptDTO;
use Tidy\UseCases\Project\DTO\ExcerptTransformer;

class ExcerptTransformerTest extends MockeryTestCase
{

    public function test_excerpt()
    {
        $transformer = new ExcerptTransformer();
        $result      = $transformer->excerpt(new ProjectSilverTongue());
        assertThat($result, is(anInstanceOf(ExcerptDTO::class)));
        assertThat($result->getName(), is(equalTo(ProjectSilverTongue::NAME)));
        assertThat($result->getCanonical(), is(equalTo(ProjectSilverTongue::CANONICAL)));
        assertThat($result->getId(), is(equalTo(ProjectSilverTongue::ID)));
    }
}