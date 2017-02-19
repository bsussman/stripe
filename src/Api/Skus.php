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

class Skus extends Api
{
    /**
     * Creates a new sku.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('skus', $parameters);
    }

    /**
     * Retrieves an existing sku.
     *
     * @param  string  $skuId
     * @return array
     */
    public function find($skuId)
    {
        return $this->_get("skus/{$skuId}");
    }

    /**
     * Updates an existing sku.
     *
     * @param  string  $skuId
     * @param  array  $parameters
     * @return array
     */
    public function update($skuId, array $parameters = [])
    {
        return $this->_post("skus/{$skuId}", $parameters);
    }

    /**
     * Deletes an existing sku.
     *
     * @param  string  $skuId
     * @return array
     */
    public function delete($skuId)
    {
        return $this->_delete("skus/{$skuId}");
    }

    /**
     * Returns a list of all the skus.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('skus', $parameters);
    }
}
