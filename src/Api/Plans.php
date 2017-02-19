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

class Plans extends Api
{
    /**
     * Creates a new plan.
     *
     * @param  array  $parameters
     * @return array
     */
    public function create(array $parameters = [])
    {
        return $this->_post('plans', $parameters);
    }

    /**
     * Retrieves an existing plan.
     *
     * @param  string  $planId
     * @return array
     */
    public function find($planId)
    {
        return $this->_get("plans/{$planId}");
    }

    /**
     * Updates an existing plan.
     *
     * @param  string  $planId
     * @param  array  $parameters
     * @return array
     */
    public function update($planId, array $parameters = [])
    {
        return $this->_post("plans/{$planId}", $parameters);
    }

    /**
     * Deletes an existing plan.
     *
     * @param  string  $planId
     * @return array
     */
    public function delete($planId)
    {
        return $this->_delete("plans/{$planId}");
    }

    /**
     * Lists all plans.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('plans', $parameters);
    }
}
