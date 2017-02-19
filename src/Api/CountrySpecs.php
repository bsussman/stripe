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

namespace WRWeb\Stripe\Api;

class CountrySpecs extends Api
{
    /**
     * Retrieves an existing country spec.
     *
     * @param  string  $country
     * @return array
     */
    public function find($country)
    {
        return $this->_get("country_specs/{$country}");
    }

    /**
     * Returns a list of all the connected country specs.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('country_specs', $parameters);
    }
}
