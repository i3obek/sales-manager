<?php

namespace App\Tests\Unit\Service\ExchangeRate\Nbp;

use App\Enum\NbpTable;
use App\Exception\NbpUrlException;
use App\Service\ExchangeRate\Nbp\NbpUrlBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 *
 * @coversNothing
 */
class NbpUrlBuilderTest extends TestCase
{
    private NbpUrlBuilder $nbpUrlBuilder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->nbpUrlBuilder = new NbpUrlBuilder();
        $this->nbpUrlBuilder->setBaseUrl('baseUrl');
    }

    #[DataProvider('buildingNbpUrlCases')]
    public function test_building_nbp_url(
        string $setter,
        $param,
        string $expected
    ) {
        $this->nbpUrlBuilder->{$setter}($param);

        $this->assertEqualsIgnoringCase($expected, $this->nbpUrlBuilder->build()->url());
    }

    public static function buildingNbpUrlCases(): array
    {
        return [
            ['setCode', 'EUR', 'baseurl/a/eur'],
            ['setTable', NbpTable::C, 'baseurl/c'],
            ['setSeriesAmount', 15, 'baseurl/a/last/15'],
            ['setDate', \DateTime::createFromFormat('dmY', '01112023'), 'baseurl/a/2023-11-01'],
        ];
    }

    public function test_building_uses_new_object()
    {
        $this->nbpUrlBuilder->setBaseUrl('www.google.com');
        $nbpUrl1 = $this->nbpUrlBuilder->build();
        $nbpUrl2 = $this->nbpUrlBuilder->build();

        $this->assertNotEquals($nbpUrl1, $nbpUrl2);
    }

    #[DataProvider('builderSetterExceptionCases')]
    public function test_exception_throwing_when_set_excluding_params(
        string $method,
        $param,
        string $assertMethod,
        $assertParam
    ) {
        $this->nbpUrlBuilder->{$method}($param);

        $this->expectException(NbpUrlException::class);
        $this->nbpUrlBuilder->{$assertMethod}($assertParam);
    }

    public static function builderSetterExceptionCases(): array
    {
        return [
            // tests setting dates
            ['setSeriesAmount', 15, 'setDate', new \DateTime()],
            ['setSeriesAmount', 15, 'setEndDate', new \DateTime()],

            // tests setting series amount
            ['setDate', new \DateTime(), 'setSeriesAmount', 15],
            ['setEndDate', new \DateTime(), 'setSeriesAmount', 15],

            // build
            ['setEndDate', new \DateTime(), 'build', null],
        ];
    }
}
