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

class AccountTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_retrieve_the_current_account_details()
    {
        $account = $this->stripe->account()->details();

        $this->assertSame('US', $account['country']);
        $this->assertSame('usd', $account['default_currency']);
    }

    /** @test */
    public function it_can_create_a_new_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'managed' => true, 'email' => $email,
        ]);

        $this->assertSame($email, $account['email']);
        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);
    }

    /** @test */
    public function it_can_retrieve_an_account()
    {
        $email = $this->getRandomEmail();

        $accountId = $this->stripe->account()->create([
            'managed' => true, 'email' => $email,
        ])['id'];

        $account = $this->stripe->account()->find($accountId);

        $this->assertSame($accountId, $account['id']);
        $this->assertSame($email, $account['email']);
        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);
    }

    /** @test */
    public function it_can_update_an_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'managed' => true, 'email' => $email,
        ]);

        $accountId = $account['id'];

        $this->assertSame($email, $account['email']);

        $email = $this->getRandomEmail();

        $this->stripe->account()->update($accountId, compact('email'));

        $account = $this->stripe->account()->find($accountId);

        $this->assertSame($accountId, $account['id']);
        $this->assertSame($email, $account['email']);
        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);
    }

    /**
     * @test
     */
    public function it_can_delete_an_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'email' => $email, 'managed' => true,
        ]);

        $this->stripe->account()->delete($account['id']);
    }

    /** @test */
    public function it_can_reject_an_account()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'managed' => true, 'email' => $email,
        ]);

        $accountId = $account['id'];

        $this->assertSame($email, $account['email']);

        $this->stripe->account()->reject($accountId, 'other');

        $account = $this->stripe->account()->find($account['id']);

        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);
    }

    /** @test */
    public function it_can_verify_an_account()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'managed' => true, 'email' => $email,
        ]);

        $this->assertSame('unverified', $account['legal_entity']['verification']['status']);

        $account = $this->stripe->account()->verify($account['id'], $filePath, 'identity_document');

        $this->assertSame('verified', $account['legal_entity']['verification']['status']);
    }

    /** @test */
    public function it_can_retrieve_all_accounts()
    {
        $email = $this->getRandomEmail();

        $account = $this->stripe->account()->create([
            'managed' => true, 'email' => $email,
        ]);

        $accounts = $this->stripe->account()->all();

        $this->assertNotEmpty($accounts['data']);
        $this->assertInternalType('array', $accounts['data']);
    }

    /** @test */
    public function it_can_iterate_all_accounts()
    {
        for ($i = 0; $i < 5; $i++) {
            $email = $this->getRandomEmail();

            $account = $this->stripe->account()->create([
                'managed' => true, 'email' => $email,
            ]);
        }

        $this->stripe->accountIterator();
    }

    /** @test */
    public function it_can_use_an_account_to_perform_actions()
    {
        $email = $this->getRandomEmail();

        $accountId = $this->stripe->account()->create([
            'managed' => true, 'email' => $email,
        ])['id'];

        $account = $this->stripe->accountId($accountId)->account()->details();

        $this->assertSame($accountId, $account['id']);

        $account = $this->stripe->accountId(null)->account()->details();

        $this->assertNotSame($accountId, $account['id']);
    }
}
