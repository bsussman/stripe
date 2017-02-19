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

class Refunds extends Api
{
    /**
     * Creates a new refund for the given charge.
     *
     * @param  string  $charge
     * @param  int  $amount
     * @param  array  $parameters
     * @return array
     */
    public function create($charge, $amount = null, array $parameters = [])
    {
        $parameters = array_merge($parameters, array_filter(compact('charge', 'amount')));

        return $this->_post('refunds', $parameters);
    }

    /**
     * Retrieves an existing refund.
     *
     * @param  string  $refundId
     * @return array
     */
    public function find($refundId)
    {
        return $this->_get("refunds/{$refundId}");
    }

    /**
     * Updates an existing refund on the given charge.
     *
     * @param  string  $refundId
     * @param  array  $parameters
     * @return array
     */
    public function update($refundId, array $parameters = [])
    {
        return $this->_post("refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all refunds for the given charge.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('refunds', $parameters);
    }
}
