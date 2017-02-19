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

class CardsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_credit_card_through_an_array()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughArray($customer['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame(1, $customer['sources']['total_count']);
    }

    /** @test */
    public function it_can_create_a_new_credit_card_through_a_token()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughToken($customer['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame(1, $customer['sources']['total_count']);
    }

    /** @test */
    public function it_can_find_an_existing_credit_card_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughToken($customer['id']);

        $card = $this->stripe->cards()->find($customer['id'], $card['id']);

        $this->assertSame('4242', $card['last4']);
    }

    /**
     * @test
     * @expectedException \WRWeb\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_card()
    {
        $customer = $this->createCustomer();

        $this->stripe->cards()->find($customer['id'], time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_credit_card_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughToken($customer['id']);

        $card = $this->stripe->cards()->update($customer['id'], $card['id'], [ 'name' => 'John Doe' ]);

        $this->assertSame('4242', $card['last4']);
        $this->assertSame('John Doe', $card['name']);
    }

    /** @test */
    public function it_can_delete_an_existing_credit_card_from_an_existing_customer()
    {
        $customer = $this->createCustomer();

        $card = $this->createCardThroughToken($customer['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame(1, $customer['sources']['total_count']);

        $this->stripe->cards()->delete($customer['id'], $card['id']);

        $customer = $this->stripe->customers()->find($customer['id']);

        $this->assertSame(0, $customer['sources']['total_count']);
    }

    /** @test */
    public function it_can_retrieve_all_cards()
    {
        $customer = $this->createCustomer();

        $this->createCardThroughToken($customer['id']);

        $cards = $this->stripe->cards()->all($customer['id']);

        $this->assertNotEmpty($cards['data']);
        $this->assertInternalType('array', $cards['data']);
    }

    /** @test */
    public function it_can_iterate_all_cards()
    {
        $customer = $this->createCustomer();

        for ($i=0; $i < 5; $i++) {
            $this->createCardThroughToken($customer['id']);
        }

        $cards = $this->stripe->cardsIterator($customer['id']);

        $this->assertCount(5, $cards);
    }
}
