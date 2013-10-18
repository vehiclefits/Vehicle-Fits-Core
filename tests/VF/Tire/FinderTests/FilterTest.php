<?php
/**
 * Vehicle Fits
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to sales@vehiclefits.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Vehicle Fits to newer
 * versions in the future. If you wish to customize Vehicle Fits for your
 * needs please refer to http://www.vehiclefits.com for more information.
 * @copyright  Copyright (c) 2013 Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class VF_Tire_FinderTest extends VF_TestCase
{
    function testFindsProductBySize()
    {
        $tireSize = new VF_TireSize(205, 55, 16);
        $this->newTireProduct(1, $tireSize);
        $this->assertEquals(array(1), $this->tireFinder()->productIds($tireSize), 'should find products with this tire size');
    }

    function testFindsProductBySizeAndType()
    {
        $tireSize = new VF_TireSize(205, 55, 16);
        $product = $this->newTireProduct(1, $tireSize, VF_Tire_Catalog_TireProduct::SUMMER_ALL);
        $actual = $this->tireFinder()->productIds($tireSize, VF_Tire_Catalog_TireProduct::SUMMER_ALL);
        $this->assertEquals(array(1), $actual, 'should find products with this tire size & tire type');
    }

    function testOmitsProductOfDifferentType()
    {
        $tireSize = new VF_TireSize(205, 55, 16);
        $product = $this->newTireProduct(1, $tireSize, VF_Tire_Catalog_TireProduct::SUMMER_ALL);
        $actual = $this->tireFinder()->productIds($tireSize, VF_Tire_Catalog_TireProduct::WINTER);
        $this->assertEquals(array(), $actual, 'should omit products of different tire type');
    }

    function testOmitsProductOfDifferentSize()
    {
        $tireSize1 = new VF_TireSize(205, 55, 16);
        $tireSize2 = new VF_TireSize(206, 56, 17);
        $product = $this->newTireProduct(1, $tireSize1);
        $this->assertEquals(array(), $this->tireFinder()->productIds($tireSize2), 'should omit products of different tire size');
    }
}