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

use WRWeb\Stripe\Stripe;
use WRWeb\Stripe\Utility;
use PHPUnit_Framework_TestCase;

class UtilityTest extends PHPUnit_Framework_TestCase
{
    /** @test */
    public function it_can_prepare_the_parameters_for_the_request()
    {
        $this->assertSame('bool=true', Utility::prepareParameters([ 'bool' => true ]));
        $this->assertSame('bool=true', Utility::prepareParameters([ 'bool' => 'true' ]));

        $this->assertSame('bool=false', Utility::prepareParameters([ 'bool' => false ]));
        $this->assertSame('bool=false', Utility::prepareParameters([ 'bool' => 'false' ]));
    }
}
