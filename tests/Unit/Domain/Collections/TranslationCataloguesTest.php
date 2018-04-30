<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 30.04.18
 *
 */

namespace Tidy\Tests\Unit\Domain\Collections;

use Tidy\Domain\Collections\TranslationCatalogues;
use Tidy\Domain\Entities\TranslationDomain;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman as Catalogue;

class TranslationCataloguesTest extends MockeryTestCase
{

    public function test_instantiation()
    {
        $catalogues = new TranslationCatalogues(mock(ITranslationGateway::class));
        assertThat($catalogues, is(notNullValue()));
    }

    public function test_findByDomain()
    {
        $gateway   = mock(ITranslationGateway::class);
        $catalogue = new Catalogue();
        $domain    = $catalogue->identifyDomain();
        $gateway->shouldReceive('findByDomain')
                ->with(anInstanceOf(TranslationDomain::class))
                ->andReturn($catalogue)
        ;
        $catalogues = new TranslationCatalogues($gateway);

        assertThat($catalogues->findByDomain( $domain ), is(sameInstance($catalogue)));
    }

}