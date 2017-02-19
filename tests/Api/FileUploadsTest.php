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

class FileUploadsTest extends FunctionalTestCase
{
    /** @test */
    public function it_can_upload_a_file()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $upload = $this->stripe->fileUploads()->create($filePath, 'identity_document');

        $this->assertSame('jpg', $upload['type']);
    }

    /** @test */
    public function it_can_retrieve_an_uploaded_file()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $uploadedFileId = $this->stripe->fileUploads()->create($filePath, 'identity_document')['id'];

        $upload = $this->stripe->fileUploads()->find($uploadedFileId);

        $this->assertSame('jpg', $upload['type']);
    }

    /** @test */
    public function it_can_retrieve_all_uploaded_files()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        $this->stripe->fileUploads()->create($filePath, 'identity_document');
        $this->stripe->fileUploads()->create($filePath, 'identity_document');
        $this->stripe->fileUploads()->create($filePath, 'identity_document');

        $uploadedFiles = $this->stripe->fileUploads()->all();

        $this->assertNotEmpty($uploadedFiles['data']);
        $this->assertInternalType('array', $uploadedFiles['data']);
    }

    /** @test */
    public function it_can_iterate_all_uploaded_files()
    {
        $filePath = realpath(__DIR__.'/../files/verify-account.jpg');

        for ($i=0; $i < 5; $i++) {
            $this->stripe->fileUploads()->create($filePath, 'identity_document');
        }

        $this->stripe->fileUploadsIterator();
    }
}
