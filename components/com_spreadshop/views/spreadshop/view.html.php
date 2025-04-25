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

/**
 * HTML View class for the SpreadShop Component
 *
 * @since  0.0.1
 */
class SpreadShopViewSpreadShop extends JViewLegacy
{
    /**
     * Display the SpreadShop view
     *
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    function display($tpl = null)
    {
        // Assign data to the view
        $this->shopId = $this->get('ShopId');
        $this->platform = $this->get('Platform');
        $this->starttoken = $this->get('Starttoken');
        $this->metadata = $this->get('Metadata');
        $this->mobileSwipeMenu = $this->get('MobileSwipeMenu');
        $this->locale = $this->get('Locale');

        if(empty($this->shopId)){
            $this->noConfiguration = JText::_('COM_SPREADSHOP_SPREADSHOP_ERROR_NOCONFIG');
        } else {
            $this->noConfiguration = '';
        }

        // Check for errors.
        if (count($errors = $this->get('Errors')))
        {
            JLog::add(implode('<br />', $errors), JLog::WARNING, 'jerror');

            return false;
        }

        // Display the view
        parent::display($tpl);
    }
}
