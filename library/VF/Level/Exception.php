<?php
/**
 * Vehicle Fits (http://www.vehiclefits.com for more information.)
 * @copyright  Copyright (c) Vehicle Fits, llc
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class VF_Level_Exception extends Exception
{

    function __construct($levelName)
    {
        $this->message = sprintf('Invalid level [%s]', $levelName);
    }
}