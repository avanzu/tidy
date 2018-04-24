<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue;

use Mockery\MockInterface;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueImpl;
use Tidy\UseCases\Translation\Catalogue\CreateCatalogue;
use Tidy\UseCases\Translation\Catalogue\DTO\CatalogueResponseDTO;
use Tidy\UseCases\Translation\Catalogue\DTO\CreateCatalogueRequestDTO;

class CreateCatalogueTest extends MockeryTestCase
{
    /**
     * @var MockInterface|\Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer
     */
    protected $transformer;

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var \Tidy\UseCases\Translation\Catalogue\CreateCatalogue
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new CreateCatalogue(
            mock(ITranslationGateway::class),
            mock(\Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer::class)
        );

        assertThat($useCase, is(notNullValue()));
    }

    public function test_execute()
    {
        $request = CreateCatalogueRequestDTO::make();
        assertThat($request, is(notNullValue()));

        $request
            ->withName('Error messages')
            ->withCanonical('errors')
            ->withSourceLocale('en', 'US')
            ->withTargetLocale('de', 'DE')
            ->withProjectId(ProjectSilverTongue::ID)
        ;

        $this->expectMakeCatalogueForProject();
        $this->expectSave();

        $response = $this->useCase->execute($request);
        assertThat($response, is(anInstanceOf(CatalogueResponseDTO::class)));
        assertThat($response->getId(), is(equalTo(2342)));
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new CreateCatalogue(
            $this->gateway
        );

    }

    protected function expectMakeCatalogueForProject(): void
    {
        $this->gateway
            ->expects('makeCatalogueForProject')
            ->with(ProjectSilverTongue::ID)
            ->andReturnUsing(
                function () {
                    $catalogue = new TranslationCatalogueImpl();
                    $catalogue->setProject(new ProjectSilverTongue());

                    return $catalogue;
                }
            )
        ;
    }

    protected function expectSave(): void
    {
        $this->gateway->expects('save')->with(
            argumentThat(
                function (TranslationCatalogue $catalogue) {
                    assertThat($catalogue->getName(), is(equalTo('Error messages')));
                    assertThat($catalogue->getCanonical(), is(equalTo('errors')));
                    assertThat($catalogue->getSourceLanguage(), is(equalTo('en')));
                    assertThat($catalogue->getSourceCulture(), is(equalTo('US')));
                    assertThat($catalogue->getTargetLanguage(), is(equalTo('de')));
                    assertThat($catalogue->getTargetCulture(), is(equalTo('DE')));

                    return true;
                }
            )
        )
                      ->andReturnUsing(
                          function ($catalogue) {
                              identify($catalogue, 2342);

                              return $catalogue;
                          }
                      )
        ;
    }


}