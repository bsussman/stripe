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

class CustomersTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_customer()
    {
        $customer = $this->createCustomer();

        $this->assertSame('john@doe.com', $customer['email']);
    }

    /** @test */
    public function it_can_find_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame('john@doe.com', $customer['email']);
    }

    /**
     * @test
     * @expectedException \WRWeb\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_customer()
    {
        $this->stripe->customers()->find(time());
    }

    /** @test */
    public function it_can_update_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->update($customer['id'], [
            'metadata' => [ 'name' => 'John Doe' ],
        ]);

        $this->assertSame('john@doe.com', $customer['email']);
        $this->assertSame('John Doe', $customer['metadata']['name']);
    }

    /** @test */
    public function it_can_delete_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->delete($customer['id']);

        $this->assertTrue($customer['deleted']);
    }

    /** @test */
    public function it_can_apply_a_discount_on_a_customer()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->applyDiscount($customer['id'], $coupon['id']);

        $this->assertSame($customer['discount']['coupon']['id'], $coupon['id']);
    }

    /** @test */
    public function it_can_delete_a_discount_from_a_customer()
    {
        $coupon = $this->createCoupon();

        $customer = $this->createCustomer();

        $customer = $this->stripe->customers()->applyDiscount($customer['id'], $coupon['id']);

        $this->assertSame($customer['discount']['coupon']['id'], $coupon['id']);

        $this->stripe->customers()->deleteDiscount($customer['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertNull($customer['discount']);
    }

    /** @test */
    public function it_can_retrieve_all_customers()
    {
        $this->createCustomer();

        $customers = $this->stripe->customers()->all();

        $this->assertNotEmpty($customers['data']);
        $this->assertInternalType('array', $customers['data']);
    }

    /** @test */
    public function it_can_iterate_all_customers()
    {
        for ($i=0; $i < 5; $i++) {
            $this->createCustomer();
        }

        $this->stripe->customersIterator();
    }
}
