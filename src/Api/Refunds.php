<?php

/**
 * Part of the Stripe package.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the 3-clause BSD License.
 *
 * This source file is subject to the 3-clause BSD License that is
 * bundled with this package in the LICENSE file.
 *
 * @package    Stripe
 * @version    3.0.0
 * @author     Cartalyst LLC
 * @license    BSD License (3-clause)
 * @copyright  (c) 2011-2017, Cartalyst LLC
 * @link       http://cartalyst.com
 */

namespace Cartalyst\Stripe\Api;

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
