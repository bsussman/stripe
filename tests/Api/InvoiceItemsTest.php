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

class InvoiceItemsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_create_a_new_invoice_item()
    {
        $customer = $this->createCustomer();

        $invoiceItem = $this->createInvoiceItem($customer['id']);

        $this->assertSame(1000, $invoiceItem['amount']);
    }

    /** @test */
    public function it_can_retrieve_an_invoice_item()
    {
        $customer = $this->createCustomer();

        $invoiceItem = $this->createInvoiceItem($customer['id']);

        $invoiceItem = $this->stripe->invoiceItems()->find($invoiceItem['id']);

        $this->assertSame(1000, $invoiceItem['amount']);
    }

    /** @test */
    public function it_can_update_an_existing_invoice_item()
    {
        $customer = $this->createCustomer();

        $invoiceItem = $this->createInvoiceItem($customer['id']);

        $invoiceItem = $this->stripe->invoiceItems()->update($invoiceItem['id'], [
            'amount' => 3000,
        ]);

        $this->assertSame(3000, $invoiceItem['amount']);
    }

    /**
     * @test
     * @expectedException \WRWeb\Stripe\Exception\NotFoundException
     */
    public function it_can_delete_an_existing_invoice_item()
    {
        $customer = $this->createCustomer();

        $invoiceItem = $this->createInvoiceItem($customer['id']);

        $itemId = $invoiceItem['id'];

        $this->assertSame(1000, $invoiceItem['amount']);

        $this->stripe->invoiceItems()->delete($itemId);

        $this->stripe->invoiceItems()->find($itemId);
    }

    /** @test */
    public function it_can_retrieve_all_invoice_items()
    {
        $customer = $this->createCustomer();

        $this->createInvoiceItem($customer['id']);

        $invoiceItems = $this->stripe->invoiceItems()->all();

        $this->assertNotEmpty($invoiceItems['data']);
        $this->assertInternalType('array', $invoiceItems['data']);
    }

    /** @test */
    public function it_can_iterate_all_invoice_items()
    {
        $customer = $this->createCustomer();

        for ($i=0; $i < 5; $i++) {
            $this->createInvoiceItem($customer['id']);
        }

        $invoiceItems = $this->stripe->invoiceItemsIterator([ 'customer' => $customer['id'] ]);

        $this->assertCount(5, $invoiceItems);
    }
}
