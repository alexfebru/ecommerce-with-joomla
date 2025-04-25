<?php
/**
 * @package com_spreadshop
 * @version 1.0.0
 * @author Marco hering
 * @copyright (C) 2017 Spreadshirt
 * @license GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

// Get an instance of the controller prefixed by SpreadShop
$controller = JControllerLegacy::getInstance('SpreadShop');

// Perform the Request task
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));

// Redirect if set by the controller
$controller->redirect();