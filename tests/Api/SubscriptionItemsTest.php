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

class SubscriptionItemsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_subscription_item()
    {
        $plan = $this->createPlan();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscriptionItem = $this->createSubscriptionItem($subscription, $plan);

        $this->assertSame($plan['id'], $subscriptionItem['plan']['id']);
    }

    /** @test */
    public function it_can_retrieve_a_subscription_item()
    {
        $plan = $this->createPlan();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscriptionItem = $this->createSubscriptionItem($subscription, $plan);

        $subscriptionItem = $this->stripe->subscriptionItems()->find($subscriptionItem['id']);

        $this->assertSame($plan['id'], $subscriptionItem['plan']['id']);
    }

    /** @test */
    public function it_can_update_an_existing_subscription_item()
    {
        $plan = $this->createPlan();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscriptionItem = $this->createSubscriptionItem($subscription, $plan);

        $this->assertSame($plan['id'], $subscriptionItem['plan']['id']);

        $plan = $this->createPlan();

        $subscriptionItem = $this->stripe->subscriptionItems()->update($subscriptionItem['id'], [
            'plan' => $plan['id'],
        ]);

        $this->assertSame($plan['id'], $subscriptionItem['plan']['id']);
    }

    /**
     * @test
     * @expectedException \WRWeb\Stripe\Exception\NotFoundException
     */
    public function it_can_delete_an_existing_subscription_item()
    {
        $plan = $this->createPlan();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $subscriptionItem = $this->createSubscriptionItem($subscription, $plan);

        $itemId = $subscriptionItem['id'];

        $this->assertSame($plan['id'], $subscriptionItem['plan']['id']);

        $this->stripe->subscriptionItems()->delete($itemId);

        $this->stripe->subscriptionItems()->find($itemId);
    }

    /** @test */
    public function it_can_retrieve_all_subscription_items()
    {
        $plan = $this->createPlan();

        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        $this->createSubscriptionItem($subscription, $plan);

        $subscriptionItems = $this->stripe->subscriptionItems()->all($subscription['id']);

        $this->assertNotEmpty($subscriptionItems['data']);
        $this->assertInternalType('array', $subscriptionItems['data']);
    }

    /** @test */
    public function it_can_iterate_all_subscription_items()
    {
        $customer = $this->createCustomer();

        $subscription = $this->createSubscription($customer['id']);

        for ($i=0; $i < 5; $i++) {
            $plan = $this->createPlan();

            $this->createSubscriptionItem($subscription, $plan);
        }

        $subscriptionItems = $this->stripe->subscriptionItemsIterator($subscription['id']);

        $this->assertCount(6, $subscriptionItems);
    }
}
