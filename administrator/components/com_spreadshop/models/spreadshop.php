<?php
/**
 * @package com_spreadshop
 * @version 2.0.1
 * @author A. Jankovics
 * @copyright (C) 2019 Spreadshirt
 * @license GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * SpreadShop admin component model
 */
class SpreadShopModelSpreadShop extends JModelList
{
    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $type    The table name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     * @return  JTable  A JTable object
     * @since   1.6
     */

    public function getTable($type = 'Spreadshop', $prefix = 'Table', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Select data for the view
     *
     * @return JDatabaseQuery
     */
    public function getListQuery()
    {
        $db = JFactory::getDBO();
        $query = $db->getQuery(true);

        $query->select('s.id,s.shop_id,s.platform');
        $query->from($db->quoteName('#__spreadshop','s'));
        $query->order('s.id');
        // Show only the first found configuration
        $this->setState('list.limit', 1);

        return $query;
    }
}
