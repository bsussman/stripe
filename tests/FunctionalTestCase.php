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

namespace WRWeb\Stripe\Tests;

use WRWeb\Stripe\Stripe;
use PHPUnit_Framework_TestCase;

class FunctionalTestCase extends PHPUnit_Framework_TestCase
{
    /**
     * The Stripe API instance.
     *
     * @var \WRWeb\Stripe\Stripe
     */
    protected $stripe;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->stripe = new Stripe();
    }

    protected function createCoupon()
    {
        return $this->stripe->coupons()->create([
            'percent_off' => 50,
            'duration'    => 'forever',
            'id'          => '50-PERCENT-OFF-'.time().rand(),
        ]);
    }

    protected function createCustomer(array $parameters = [])
    {
        return $this->stripe->customers()->create(array_merge([
            'email' => 'john@doe.com',
        ], $parameters));
    }

    protected function createPlan()
    {
        return $this->stripe->plans()->create([
            'amount'               => 3000,
            'currency'             => 'USD',
            'interval'             => 'month',
            'name'                 => 'Monthly (30$)',
            'statement_descriptor' => 'Monthly Subscription.',
            'id'                   => 'monthly-'.time().rand(),
        ]);
    }

    protected function createProduct()
    {
        return $this->stripe->products()->create([
            'name'        => 'T-shirt',
            'attributes'  => [ 'size', 'gender' ],
            'description' => 'Comfortable gray cotton t-shirts',
        ]);
    }

    protected function createSku($productId)
    {
        return $this->stripe->skus()->create([
            'product'   => $productId,
            'price'     => 1500,
            'currency'  => 'usd',
            'inventory' => [
                'type'     => 'finite',
                'quantity' => 500
            ],
            'attributes' => [
                'size'   => 'Medium',
                'gender' => 'Unisex',
            ],
        ]);
    }

    protected function createCardToken()
    {
        return $this->stripe->tokens()->create([
            'card' => [
                'exp_month' => 10,
                'cvc'       => 314,
                'exp_year'  => 2020,
                'number'    => '4242424242424242',
            ],
        ]);
    }

    protected function createBankAccountToken()
    {
        return $this->stripe->tokens()->create([
            'bank_account' => [
                'country'             => 'US',
                'currency'            => 'usd',
                'account_holder_name' => 'Jane Austen',
                'account_holder_type' => 'individual',
                'routing_number'      => '110000000',
                'account_number'      => '000123456789',
            ],
        ]);
    }

    protected function createBankAccountThroughArray($customerId)
    {
        return $this->stripe->bankAccounts()->create($customerId, [
            'country'             => 'US',
            'currency'            => 'usd',
            'account_holder_name' => 'Jane Austen',
            'account_holder_type' => 'individual',
            'routing_number'      => '110000000',
            'account_number'      => '000123456789',
        ]);
    }

    protected function createBankAccountThroughToken($customerId)
    {
        $token = $this->createBankAccountToken();

        return $this->stripe->bankAccounts()->create($customerId, $token['id']);
    }

    protected function createCardThroughArray($customerId)
    {
        return $this->stripe->cards()->create($customerId, [
            'exp_month' => 10,
            'cvc'       => 314,
            'exp_year'  => 2020,
            'number'    => '4242424242424242',
            'currency'  => 'usd',
        ]);
    }

    protected function createCardThroughToken($customerId)
    {
        $token = $this->createCardToken();

        return $this->stripe->cards()->create($customerId, $token['id']);
    }

    protected function createCharge($customerId, array $parameters = [])
    {
        $this->createCardThroughToken($customerId);

        return $this->stripe->charges()->create(array_merge([
            'currency' => 'USD',
            'amount'   => 5049,
            'customer' => $customerId,
        ], $parameters));
    }

    protected function createSubscription($customerId, array $parameters = [])
    {
        $this->createCardThroughToken($customerId);

        $plan = $this->createPlan();

        return $this->stripe->subscriptions()->create($customerId, array_merge([
            'plan' => $plan['id']
        ], $parameters));
    }

    protected function createSubscriptionItem($subscription, $plan)
    {
        return $this->stripe->subscriptionItems()->create($subscription['id'], $plan['id']);
    }

    protected function createOrder(array $items)
    {
        return $this->stripe->orders()->create([
            'currency' => 'usd',
            'items' => $items,
            'shipping' => [
                'name'    => 'Jenny Rosen',
                'address' => [
                    'line1'       => '1234 Main street',
                    'city'        => 'Anytown',
                    'country'     => 'US',
                    'postal_code' => '123456',
                ],
            ],
            'email' => 'jenny@ros.en'
        ]);
    }

    protected function createRecipient()
    {
        return $this->stripe->recipients()->create([
            'name' => 'John Doe',
            'type' => 'individual',
        ]);
    }

    protected function createInvoice($customerId, array $parameters = [])
    {
        return $this->stripe->invoices()->create($customerId, $parameters);
    }

    protected function createInvoiceItem($customerId, array $parameters = [])
    {
        return $this->stripe->invoiceItems()->create($customerId, array_merge([
            'amount'      => 1000,
            'currency'    => 'usd',
            'description' => 'One-time setup fee.'
        ], $parameters));
    }

    protected function createAnInvoiceAndInvoiceItems($customerId, $amountOfInvoiceItems = 2)
    {
        for ($i=0; $i < $amountOfInvoiceItems; $i++) {
            $this->createInvoiceItem($customerId);
        }

        return $this->createInvoice($customerId);
    }

    protected function getRandomEmail()
    {
        return rand().time().'-john@doe.com';
    }
}
