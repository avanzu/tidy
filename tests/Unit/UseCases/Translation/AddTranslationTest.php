<?php
/**
 * This file is part of the "Tidy" Project.
 *
 * Created by avanzu on 22.04.18
 *
 */

namespace Tidy\Tests\Unit\UseCases\Translation;

use Mockery\MockInterface;
use Tidy\Components\Exceptions\NotFound;
use Tidy\Domain\Entities\Translation;
use Tidy\Domain\Entities\TranslationCatalogue;
use Tidy\Domain\Gateways\ITranslationGateway;
use Tidy\Tests\MockeryTestCase;
use Tidy\Tests\Unit\Domain\Entities\TranslationCatalogueEnglishToGerman;
use Tidy\Tests\Unit\Domain\Entities\TranslationImpl;
use Tidy\UseCases\Translation\AddTranslation;
use Tidy\UseCases\Translation\DTO\AddTranslationRequestDTO;
use Tidy\UseCases\Translation\DTO\CatalogueResponseDTO;
use Tidy\UseCases\Translation\DTO\CatalogueResponseTransformer;
use Tidy\UseCases\Translation\DTO\TranslationResponseDTO;
use Tidy\UseCases\Translation\DTO\TranslationResponseTransformer;

class AddTranslationTest extends MockeryTestCase
{

    /**
     * @var AddTranslation
     */
    protected $useCase;

    /**
     * @var ITranslationGateway|MockInterface
     */
    private   $gateway;

    const MEANING = 'Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Curabitur luctus lacus eros. Mauris tortor lacus, condimentum nec eleifend in, aliquet ut metus. Sed varius tellus vitae nisi congue eu fringilla tellus aliquet. Nulla suscipit porttitor velit, id lobortis orci congue at. Nunc a dolor nulla. Integer quis dignissim ante. ';

    const NOTES = 'Sed libero ipsum, auctor ac volutpat ac, adipiscing a enim. Nulla convallis quam eget tortor dictum lobortis. Aenean tincidunt arcu id lectus facilisis imperdiet. Curabitur in orci nisl. Nullam vitae arcu in tellus malesuada sollicitudin ut in sem. Ut eu nunc lacus, sit amet venenatis mauris. Donec dui neque, cursus sed molestie sit amet, tempor quis nibh. Proin nec ligula non lacus fermentum tincidunt. Nam tempus lectus ut dolor imperdiet quis commodo odio porttitor. Fusce blandit placerat posuere. Pellentesque risus leo, tempor sit amet consequat tempus, dictum vel magna. Nulla dolor turpis, dignissim a sodales quis, molestie molestie magna. Vivamus imperdiet vestibulum tellus, quis rutrum magna eleifend quis. Pellentesque convallis metus nisl. Sed eu dolor massa, sit amet luctus nulla. Mauris sit amet diam urna, eget volutpat nunc. ';

    public function test_instantiation()
    {
        $useCase = new AddTranslation(mock(ITranslationGateway::class));
        assertThat($useCase, is(notNullValue()));


    }

    public function test_swapTransformer()
    {
        $initial = mock(CatalogueResponseTransformer::class);
        $swapped  = mock(CatalogueResponseTransformer::class);

        $useCase = new AddTranslation($this->gateway, $initial);
        $result = $useCase->swapTransformer($swapped);

        assertThat($result, is(sameInstance($initial)));
        assertThat($useCase->swapTransformer($initial), is(sameInstance($swapped)));
    }

    public function test_execute_success()
    {
        $request = AddTranslationRequestDTO::make();
        $request
            ->withCatalogueId(TranslationCatalogueEnglishToGerman::ID)
            ->withSourceString('source code')
            ->withLocaleString('Quelltext')
            ->withMeaning(self::MEANING)
            ->withNotes(self::NOTES)
            ->withState('translated')
            ->withToken('message.source_code')
        ;

        $this->gateway
            ->expects('findCatalogue')
            ->with(TranslationCatalogueEnglishToGerman::ID)
            ->andReturn(new TranslationCatalogueEnglishToGerman())
        ;

        $expected = new TranslationImpl();
        $this->gateway->expects('makeTranslation')->andReturn($expected);
        $this->gateway->expects('save')->with(argumentThat(function(TranslationCatalogue $catalogue) use ($expected){
            assertThat($catalogue->find('message.source_code'), is(sameInstance($expected)));
            return true;
        }))
        ;

        $result = $this->useCase->execute($request);

        assertThat($result, is(anInstanceOf(CatalogueResponseDTO::class)));

    }

    public function test_execute_fail()
    {
        $request = AddTranslationRequestDTO::make();
        $wrongId      = 12345678909876543;
        $request
            ->withCatalogueId($wrongId)
        ;

        $this->gateway->expects('findCatalogue')->with($wrongId)->andReturnNull();

        try {
            $this->useCase->execute($request);
            $this->fail('Failed to fail');

        } catch(\Exception $e) {
            assertThat($e, is(anInstanceOf(NotFound::class)));
            $this->assertStringMatchesFormat('Unable to find catalogue identified by "%d".', $e->getMessage());
        }

    }




    protected function setUp()/* The :void return type declaration that should be here would cause a BC issue */
    {
        parent::setUp();

        $this->gateway = mock(ITranslationGateway::class);
        $this->useCase = new AddTranslation($this->gateway);
    }

}