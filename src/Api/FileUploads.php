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

namespace WRWeb\Stripe\Api;

class FileUploads extends Api
{
    /**
     * {@inheritdoc}
     */
    public function baseUrl()
    {
        return 'https://uploads.stripe.com';
    }

    /**
     * Creates a file upload.
     *
     * @param  string  $file
     * @param  string  $purpose
     * @param  array  $headers
     * @return array
     */
    public function create($file, $purpose, array $headers = [])
    {
        $response = $this->getClient()->request('POST', 'v1/files', [
            'headers'   => $headers,
            'multipart' => [
                [ 'name' => 'purpose', 'contents' => $purpose ],
                [ 'name' => 'file', 'contents' => fopen($file, 'r') ]
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * Retrieves an existing file upload.
     *
     * @param  string  $fileId
     * @return array
     */
    public function find($fileId)
    {
        return $this->_get("files/{$fileId}");
    }

    /**
     * Lists all file uploads.
     *
     * @param  array  $parameters
     * @return array
     */
    public function all(array $parameters = [])
    {
        return $this->_get('files', $parameters);
    }
}
