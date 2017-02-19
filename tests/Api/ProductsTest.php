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

class ProductsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_product()
    {
        $product = $this->createProduct();

        $this->assertSame('T-shirt', $product['name']);
    }

    /** @test */
    public function it_can_find_an_existing_product()
    {
        $product = $this->createProduct();

        $product = $this->stripe->products()->find($product['id']);

        $this->assertSame('T-shirt', $product['name']);
    }

    /**
     * @test
     * @expectedException \WRWeb\Stripe\Exception\NotFoundException
     */
    public function it_will_throw_an_exception_when_searching_for_a_non_existing_product()
    {
        $this->stripe->products()->find(time().rand());
    }

    /** @test */
    public function it_can_update_an_existing_product()
    {
        $product = $this->createProduct();

        $product = $this->stripe->products()->update($product['id'], [
            'description' => 'Comfortable gray cotton t-shirt'
        ]);

        $this->assertSame('T-shirt', $product['name']);
        $this->assertSame('Comfortable gray cotton t-shirt', $product['description']);
    }

    /** @test */
    public function it_can_delete_an_existing_product()
    {
        $product = $this->createProduct();

        $product = $this->stripe->products()->update($product['id'], [
            'description' => 'Comfortable gray cotton t-shirt'
        ]);

        $product = $this->stripe->products()->delete($product['id']);

        $this->assertTrue($product['deleted']);
    }

    /** @test */
    public function it_can_retrieve_all_products()
    {
        $this->createProduct();

        $products = $this->stripe->products()->all();

        $this->assertNotEmpty($products['data']);
        $this->assertInternalType('array', $products['data']);
    }

    /** @test */
    public function it_can_iterate_all_products()
    {
        for ($i=0; $i < 5; $i++) {
            $this->createProduct();
        }

        $this->stripe->productsIterator();
    }
}
