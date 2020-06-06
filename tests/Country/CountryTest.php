<?php
namespace Numverify\Tests\Country;

use Numverify\Country\Country;

class CountryTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @testCase getters
     */
    public function testGetters()
    {
        // Given
        $country = new Country(self::COUNTRY_CODE, self::COUNTRY_NAME, self::DIALLING_CODE);

        // When
        $countryCode  = $country->getCountryCode();
        $countryName  = $country->getCountryName();
        $diallingCode = $country->getDialingCode();

        // Then
        $this->assertSame(self::COUNTRY_CODE, $countryCode);
        $this->assertSame(self::COUNTRY_NAME, $countryName);
        $this->assertSame(self::DIALLING_CODE, $diallingCode);
    }

    /**
     * @testCase JsonSerialize interface
     */
    public function testJsonSerializeInterface()
    {
        // Given
        $country = new Country(self::COUNTRY_CODE, self::COUNTRY_NAME, self::DIALLING_CODE);

        // When
        $json = json_encode($country);

        // Then
        $object = json_decode($json);
        $this->assertSame(self::COUNTRY_CODE, $object->countryCode);
        $this->assertSame(self::COUNTRY_NAME, $object->countryName);
        $this->assertSame(self::DIALLING_CODE, $object->diallingCode);
    }

    /* ********* *
     * TEST DATA
     * ********* */

    const COUNTRY_CODE  = 'US';
    const COUNTRY_NAME  = 'United States';
    const DIALLING_CODE = '+1';
}
