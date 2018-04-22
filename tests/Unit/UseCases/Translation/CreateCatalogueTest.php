<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\IProjectGateway;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\ICatalogueResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\ProjectSilverTongue;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueImpl;
use Tidy\UseCases\Translation\CreateCatalogue;
use Tidy\UseCases\Translation\DTO\CatalogueResponseDTO;
use Tidy\UseCases\Translation\DTO\CreateCatalogueRequestDTO;

class CreateCatalogueTest extends MockeryTestCase
{
    /**
     * @var MockInterface|ICatalogueResponseTransformer
     */
    protected $transformer;

    /**
     * @var ITranslationGateway|MockInterface
     */
    protected $gateway;

    /**
     * @var CreateCatalogue
     */
    protected $useCase;

    public function test_instantiation()
    {
        $useCase = new CreateCatalogue(
            mock(ITranslationGateway::class),
            mock(ICatalogueResponseTransformer::class)
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

        $this->gateway
            ->expects('makeCatalogueForProject')
            ->with(ProjectSilverTongue::ID)
            ->andReturnUsing(function (){
                $catalogue = new TranslationCatalogueImpl();
                $catalogue->setProject(new ProjectSilverTongue());
                return $catalogue;
            })
        ;

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

        $response = $this->useCase->execute($request);
        assertThat($response, is(anInstanceOf(CatalogueResponseDTO::class)));
        assertThat($response->getId(), is(equalTo(2342)));
    }

    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();
        $this->gateway        = mock(ITranslationGateway::class);
        $this->useCase        = new CreateCatalogue(
            $this->gateway
        );

    }


}