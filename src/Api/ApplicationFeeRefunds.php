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

class ApplicationFeeRefunds extends Api
{
    /**
     * Creates a new application fee refund.
     *
     * @param  string  $applicationFeeId
     * @param  array  $parameters
     * @return array
     */
    public function create($applicationFeeId, array $parameters = [])
    {
        return $this->_post("application_fees/{$applicationFeeId}/refunds", $parameters);
    }

    /**
     * Retrieves an existing application fee refund.
     *
     * @param  string  $applicationFeeId
     * @param  string  $refundId
     * @return array
     */
    public function find($applicationFeeId, $refundId)
    {
        return $this->_get("application_fees/{$applicationFeeId}/refunds/{$refundId}");
    }

    /**
     * Updates an existing application fee refund.
     *
     * @param  string  $applicationFeeId
     * @param  string  $refundId
     * @param  array  $parameters
     * @return array
     */
    public function update($applicationFeeId, $refundId, array $parameters = [])
    {
        return $this->_post("application_fees/{$applicationFeeId}/refunds/{$refundId}", $parameters);
    }

    /**
     * Lists all application fee refunds.
     *
     * @param  string  $applicationFeeId
     * @param  array  $parameters
     * @return array
     */
    public function all($applicationFeeId, array $parameters = [])
    {
        return $this->_get("application_fees/{$applicationFeeId}/refunds", $parameters);
    }
}
