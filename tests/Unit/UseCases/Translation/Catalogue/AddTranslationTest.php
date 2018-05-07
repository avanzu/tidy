<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation\Catalogue;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\Duplicate;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Components\Exceptions\PreconditionFailed;
use Tidy\Domain\BusinessRules\TranslationRules;
use Tidy\Domain\Collections\TranslationCatalogues;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponse;
use Tidy\Domain\Responders\Translation\Catalogue\ICatalogueResponseTransformer;
use Tidy\Domain\Responders\Translation\Catalogue\ItemResponder;
use Tidy\Domain\Responders\Translation\Message\ITranslationResponse;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationImpl;
use Tidy\Tests\Unit\Fixtures\Entities\TranslationTranslated;
use Tidy\UseCases\Translation\Catalogue\AddTranslation;
use Tidy\UseCases\Translation\Catalogue\DTO\AddTranslationRequestBuilder;

class AddTranslationTest extends MockeryTestCase
{

    const MEANING = 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur luctus lacus eros. Mauris tortor lacus, condimentum nec eleifend in, aliquet ut metus. Sed varius tellus vitae nisi congue eu fringilla tellus aliquet. Nulla suscipit porttitor velit, id lobortis orci congue at. Nunc a dolor nulla. Integer quis dignissim ante. ';

    const NOTES = 'Sed libero ipsum, auctor ac volutpat ac, adipiscing a enim. Nulla convallis quam eget tortor dictum lobortis. Aenean tincidunt arcu id lectus facilisis imperdiet. Curabitur in orci nisl. Nullam vitae arcu in tellus malesuada sollicitudin ut in sem. Ut eu nunc lacus, sit amet venenatis mauris. Donec dui neque, cursus sed molestie sit amet, tempor quis nibh. Proin nec ligula non lacus fermentum tincidunt. Nam tempus lectus ut dolor imperdiet quis commodo odio porttitor. Fusce blandit placerat posuere. Pellentesque risus leo, tempor sit amet consequat tempus, dictum vel magna. Nulla dolor turpis, dignissim a sodales quis, molestie molestie magna. Vivamus imperdiet vestibulum tellus, quis rutrum magna eleifend quis. Pellentesque convallis metus nisl. Sed eu dolor massa, sit amet luctus nulla. Mauris sit amet diam urna, eget volutpat nunc. ';

    /**
     * @var AddTranslation
     */
    protected $useCase;

    /**
     * @var ITranslationGateway|MockInterface
     */
    private $gateway;

    public function test_instantiation()
    {
        $useCase = new AddTranslation(mock(ITranslationGateway::class), mock(TranslationRules::class));
        assertThat($useCase, is(notNullValue()));

    }

    public function test_swapTransformer()
    {
        $initial = mock(ICatalogueResponseTransformer::class);
        $swapped = mock(ICatalogueResponseTransformer::class);

        $useCase = new AddTranslation($this->gateway, mock(TranslationRules::class), $initial);
        $result  = $useCase->swapTransformer($swapped);

        assertThat($result, is(sameInstance($initial)));
        assertThat($useCase->swapTransformer($initial), is(sameInstance($swapped)));
    }

    public function test_execute_success()
    {
        $request = (new AddTranslationRequestBuilder())
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withSourceString('source code')
            ->withLocaleString('Quelltext')
            ->withMeaning(self::MEANING)
            ->withNotes(self::NOTES)
            ->withState('translated')
            ->withToken('message.source_code')
            ->build()
        ;

        $this->expectFindCatalogue();
        $this->expectSave('message.source_code');

        $result = $this->useCase->execute($request);

        assertThat($result, is(anInstanceOf(ICatalogueResponse::class)));
        assertThat(count($result), is(equalTo(3)));
        $this->assertContainsOnlyInstancesOf(ITranslationResponse::class, $result->translations());

    }

    public function test_execute_fails_on_unknown_catalogue()
    {
        $wrongId = 12345678909876543;
        $request = (new AddTranslationRequestBuilder())->withCatalogueId($wrongId)->build();

        $this->gateway->expects('findCatalogue')->with($wrongId)->andReturnNull();

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail');

        } catch (\Exception $e) {
            assertThat($e, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $e->getMessage());
        }

    }

    public function test_execute_fails_on_duplicate_token()
    {
        $request = (new AddTranslationRequestBuilder())
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withToken(TranslationTranslated::MSG_ID)
            ->build()
        ;

        $this->gateway->expects('findCatalogue')->andReturn(new TranslationCatalogueEnglishToGerman());
        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail.');

        } catch (\Exception $exception) {
            assertThat($exception, is(anInstanceOf(PreconditionFailed::class)));
            $this->assertStringMatchesFormat(
                'Token %s already exists translated as "%s".',
                $exception->getErrors()->atIndex('token')
            );
        }

    }


    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->gateway = mock(ITranslationGateway::class);
        $rules = new TranslationRules(new TranslationCatalogues($this->gateway));
        $this->useCase = new AddTranslation($this->gateway, $rules);
    }

    protected function expectFindCatalogue(): void
    {
        $this->gateway
            ->expects('findCatalogue')
            ->with(TranslationCatalogueEnglishToGerman::ID)
            ->andReturn(new TranslationCatalogueEnglishToGerman())
        ;
    }

    /**
     * @return TranslationImpl
     */
    protected function expectSave($token)
    {
        $this
            ->gateway
            ->expects('save')
            ->with(
                argumentThat(
                    function (TranslationCatalogue $catalogue) use ($token) {
                        assertThat($catalogue->find($token), is(anInstanceOf(Translation::class)));

                        return true;
                    }
                )
            )
            ->andReturnUsing(
                function (TranslationCatalogue $catalogue) {
                    identify($catalogue->find('message.source_code'), 47110815);

                    return $catalogue;
                }
            )
        ;
    }

}