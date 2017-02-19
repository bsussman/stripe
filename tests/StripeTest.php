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

use Mockery as m;
use WRWeb\Stripe\Stripe;
use PHPUnit_Framework_TestCase;

class StripeTest extends PHPUnit_Framework_TestCase
{
    /**
     * The Stripe API client instance.
     *
     * @var \WRWeb\Stripe\Stripe
     */
    protected $stripe;

    /**
     * Setup resources and dependencies
     *
     * @return void
     */
    public function setUp()
    {
        $this->stripe = new Stripe('stripe-api-key', '2014-06-17');
    }

    /**
     * Close mockery.
     *
     * @return void
     */
    public function tearDown()
    {
        m::close();
    }

    /** @test */
    public function it_can_create_a_new_instance_using_the_make_method()
    {
        $stripe = Stripe::make('stripe-api-key');

        $this->assertEquals('stripe-api-key', $stripe->getApiKey());
    }

    /** @test */
    public function it_can_create_a_new_instance_using_enviroment_variables()
    {
        $stripe = new Stripe;

        $this->assertEquals(getenv('STRIPE_API_KEY'), $stripe->getApiKey());

        $this->assertEquals(getenv('STRIPE_API_VERSION'), $stripe->getApiVersion());
    }

    /** @test */
    public function it_can_get_and_set_the_api_key()
    {
        $this->stripe->setApiKey('new-stripe-api-key');

        $this->assertEquals('new-stripe-api-key', $this->stripe->getApiKey());
    }

    /**
     * @test
     * @expectedException \RuntimeException
     */
    public function it_throws_an_exception_when_the_api_key_is_not_set()
    {
        // Unset the environment variable
        putenv('STRIPE_API_KEY');

        new Stripe;
    }

    /** @test */
    public function it_can_get_and_set_the_api_version()
    {
        $this->stripe->setApiVersion('2014-03-28');

        $this->assertEquals('2014-03-28', $this->stripe->getApiVersion());
    }

    /** @test */
    public function it_can_get_the_current_package_version()
    {
        $this->stripe->getVersion();
    }

    /** @test */
    public function it_can_create_requests()
    {
        $this->stripe->customers();
    }

    /**
     * @test
     * @expectedException \BadMethodCallException
     */
    public function it_throws_an_exception_when_the_request_is_invalid()
    {
        $this->stripe->foo();
    }
}
