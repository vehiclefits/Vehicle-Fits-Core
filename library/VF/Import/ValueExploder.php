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
class VF_Import_ValueExploder
{
    protected $i;
    protected $input;
    protected $exploderToken = '{{all}}';
    protected $wildCardToken = '*';
    /** @var VF_Schema */
    protected $schema;
    /** @var Zend_Db_Adapter_Abstract */
    protected $readAdapter;
    /** @var  VF_Vehicle_Finder */
    protected $vehicleFinder;

    public function __construct(VF_Schema $schema, Zend_Db_Adapter_Abstract $readAdapter, VF_Vehicle_Finder $vehicleFinder) {
        $this->schema = $schema;
        $this->readAdapter = $readAdapter;
        $this->vehicleFinder = $vehicleFinder;
    }

    function explode($input)
    {
        $this->input = $input;
        if (!$this->hasWildCards()) {
            return array($input);
        }
        $this->result = array();
        $this->i = 0;
        $this->replaceAllWithWildcard();
        $result = array();

        foreach ($this->vehicleFinder->findByLevels($this->input) as $vehicle) {
            array_push($result, $vehicle->toTitleArray());
        }
        return $result;
    }

    function replaceAllWithWildcard()
    {
        foreach ($this->getSchema()->getLevels() as $level) {
            if ($this->isExploderToken($level)) {
                $this->input[$level] = '*';
            }
        }
    }

    function hasWildCards()
    {
        foreach ($this->getSchema()->getLevels() as $level) {
            if ($this->isExploderToken($level) || false !== strpos($this->input[$level], $this->wildCardToken)) {
                return true;
            }
        }
        return false;
    }

    function isExploderToken($level)
    {
        return $this->exploderToken == $this->input[$level];
    }

    function getSchema()
    {
        return $this->schema;
    }

    /** @return Zend_Db_Adapter_Abstract */
    protected function getReadAdapter()
    {
        return $this->readAdapter;
    }
}