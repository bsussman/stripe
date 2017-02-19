<?php

/**
 * Part of the WRWeb_Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * Part of the WRWeb_Stripe package.
 * @version    0.0.9
 * @author     Brandon Sussman (WRWeb)
 * @license    BSD License (3-clause)
 * @copyright  (c) 2017, WRWeb
 * @link       http://wrweb.net
 */

namespace WRWeb\Stripe\Tests\Api;

use WRWeb\Stripe\Tests\FunctionalTestCase;

class CountrySpecsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_get_a_country_spec()
    {
        $countrySpec = $this->stripe->countrySpecs()->find('US');

        $this->assertArrayHasKey('usd', $countrySpec['supported_bank_account_currencies']);
    }

    /** @test */
    public function it_can_get_all_country_specs()
    {
        $countrySpecs = $this->stripe->countrySpecs()->all();

        $this->assertGreaterThan(1, count($countrySpecs['data']));
    }
}
