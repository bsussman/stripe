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

class RefundsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id']);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertTrue($charge['refunded']);
        $this->assertSame(5049, $refund['amount']);
    }

    /** @test */
    public function it_can_create_a_partial_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id'], 2000);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertFalse($charge['refunded']);
        $this->assertSame(2000, $refund['amount']);
    }

    /** @test */
    public function it_can_find_a_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id']);

        $refund = $this->stripe->refunds()->find($refund['id']);

        $charge = $this->stripe->charges()->find($charge['id']);

        $this->assertTrue($charge['refunded']);
        $this->assertSame(5049, $refund['amount']);
    }

    /**
     * @test
     * @expectedException \WRWeb\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_refund()
    {
        $this->stripe->refunds()->find(time().rand());
    }

    /** @test */
    public function it_can_update_a_refund()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $refund = $this->stripe->refunds()->create($charge['id']);

        $refund = $this->stripe->refunds()->update($refund['id'], [
            'metadata' => [ 'reason' => 'Refunded the payment.' ]
        ]);

        $this->assertSame(5049, $refund['amount']);
        $this->assertSame('Refunded the payment.', $refund['metadata']['reason']);
    }

    /** @test */
    public function it_can_retrieve_all_refunds()
    {
        $customer = $this->createCustomer();

        $charge = $this->createCharge($customer['id']);

        $this->stripe->refunds()->create($charge['id']);

        $refunds = $this->stripe->refunds()->all([
            'charge' => $charge['id']
        ]);

        $this->assertCount(1, $refunds['data']);
        $this->assertInternalType('array', $refunds['data']);
    }
}
