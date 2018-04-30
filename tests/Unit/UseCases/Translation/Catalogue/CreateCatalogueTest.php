<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Entities\TranslationDomain;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\ProjectSilverTongue;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueImpl;
use Tidy\UseCases\Translation\Catalogue\CreateCatalogue;
use Tidy\UseCases\Translation\Catalogue\DTO\CatalogueResponseDTO;
use Tidy\UseCases\Translation\Catalogue\DTO\CreateCatalogueRequestBuilder;

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
     * @var \Tidy\UseCases\Translation\Catalogue\CreateCatalogue
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
        $request = (new CreateCatalogueRequestBuilder())
            ->withName('Error messages')
            ->withCanonical('errors')
            ->withSourceLocale('en', 'US')
            ->withTargetLocale('de', 'DE')
            ->withProjectId(ProjectSilverTongue::ID)
            ->build()
        ;

        $expectedDomain = new TranslationDomain('errors', 'en', 'US', 'de', 'DE');
        $this->expectMakeCatalogueForProject();
        $this->expectDomainLookupWithoutMatch($expectedDomain);

        $this->expectSave();

        $response = $this->useCase->execute($request);
        assertThat($response, is(anInstanceOf(CatalogueResponseDTO::class)));
        assertThat($response->getId(), is(equalTo(2342)));
    }

    public function test_execute_precondition_check()
    {
        $request = (new CreateCatalogueRequestBuilder())
            ->withName('')
            ->withCanonical('')
            ->withSourceLocale('abc', 'lala')
            ->withTargetLocale('', 'DE')
            ->withProjectId(ProjectSilverTongue::ID)
            ->build()
        ;

        $this->expectMakeCatalogueForProject();

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail.');
        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
        }

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

    /**
     * @param $expectedDomain
     */
    private function expectDomainLookupWithoutMatch($expectedDomain): void
    {
        $this->gateway->expects('findByDomain')->with(equalTo($expectedDomain))->andReturn(null);
    }


}