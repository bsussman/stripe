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

class Balance extends Api
{
    /**
     * Retrieives the current account balance.
     *
     * @return array
     */
    public function current()
    {
        return $this->_get('balance');
    }

    /**
     * Retrieves the balance transaction for the given id.
     *
     * @param  string  $transactionId
     * @return array
     */
    public function find($transactionId)
    {
        return $this->_get("balance/history/{$transactionId}");
    }

    /**
     * Lists all transactions
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('balance/history', $parameters);
    }
}
