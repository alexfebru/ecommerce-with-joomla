<?php
/**
 * @package com_spreadshop
 * @version 1.0.0
 * @author A. Jankovics
 * @copyright (C) 2017 Spreadshirt
 * @license GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

$controller = JControllerLegacy::getInstance('SpreadShop');
$input = JFactory::getApplication()->input;
$controller->execute($input->getCmd('task'));
$controller->redirect();