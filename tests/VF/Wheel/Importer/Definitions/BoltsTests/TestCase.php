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
abstract class VF_Wheel_Importer_Definitions_BoltsTests_TestCase extends VF_TestCase
{
    function importVehicleBolts($stringData)
    {
        $csvFile = TEMP_PATH . '/bolt-definitions.csv';
        file_put_contents($csvFile, $stringData);
        $importer = $this->getVehicleBoltImporter($csvFile, $this->getServiceContainer());
        $importer->import();
    }

    function getVehicleBoltImporter($csvFile, VF_ServiceContainer $container)
    {
        return new VF_Wheel_Importer_Definitions_Bolts($csvFile, $container->getSchemaClass(
            ), $container->getReadAdapterClass(), $container->getConfigClass(), $container->getLevelFinderClass(
        ), $container->getVehicleFinderClass());
    }

    function findVehicleByLevelsMMY($make, $model, $year)
    {
        $vehicle = parent::findVehicleByLevelsMMY($make, $model, $year);
        return new VF_Wheel_Vehicle($this->getServiceContainer()->getReadAdapterClass(), $vehicle);
    }

    function findVehicleByLevelsYMM($year, $make, $model)
    {
        $vehicle = parent::findVehicleByLevelsYMM($year, $make, $model);
        return new VF_Wheel_Vehicle($this->getServiceContainer()->getReadAdapterClass(), $vehicle);
    }

    function findVehicleByLevelsMMOY($make, $model, $option, $year)
    {
        $vehicle = parent::findVehicleByLevelsMMOY($make, $model, $option, $year);
        return new VF_Wheel_Vehicle($this->getServiceContainer()->getReadAdapterClass(), $vehicle);
    }
}