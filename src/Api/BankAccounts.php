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

class BankAccounts extends Sources
{
    /**
     * The source type.
     *
     * @var string
     */
    protected $sourceType = 'bank_account';

    /**
     * Verifies the given bank account.
     *
     * @param  string  $customerId
     * @param  string  $bankAccountId
     * @param  array  $amounts
     * @param  string  $verificationMethod
     * @return array
     */
    public function verify($customerId, $bankAccountId, array $amounts, $verificationMethod = null)
    {
        return $this->_post("customers/{$customerId}/sources/{$bankAccountId}/verify", [
            'amounts' => $amounts, 'verification_method' => $verificationMethod,
        ]);
    }
}
