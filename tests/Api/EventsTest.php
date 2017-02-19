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

class EventsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_retrieve_a_single_and_all_events()
    {
        $this->createCustomer();

        $events = $this->stripe->events()->all();

        $this->assertNotEmpty($events['data']);
        $this->assertInternalType('array', $events['data']);

        $event = $this->stripe->events()->find($events['data'][0]['id']);
    }
}
