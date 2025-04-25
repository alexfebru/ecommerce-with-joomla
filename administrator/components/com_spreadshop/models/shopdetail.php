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
class SpreadshopModelShopdetail extends JModelAdmin
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
     * Method to get the record form.
     *
     * @param   array    $data      Data for the form.
     * @param   boolean  $loadData  True if the form is to load its own data (default case), false if not.
     * @return  mixed    A JForm object on success, false on failure
     * @since   1.6
     */
    public function getForm($data = array(), $loadData = true)
    {
        // Get the form.
        $form = $this->loadForm(
            'com_spreadshop.shopdetail',
            'shopdetail',
            [
                'control' => 'jform',
                'load_data' => $loadData,
            ]
        );

        if (empty($form)) {
            return false;
        }

        return $form;
    }

    /**
     * Method to get the data that should be injected in the form.
     *
     * @return  mixed  The data for the form.
     * @since   1.6
     * @throws Exception
     */
    protected function loadFormData()
    {
        // Check the session for previously entered form data.
        $data = JFactory::getApplication()->getUserState(
            'com_spreadshop.edit.shopdetail.data',
            array()
        );

        if (empty($data))
        {
            $data = $this->getItem();
        }

        return $data;
    }

    /**
     * Saves a item record
     *
     * @param array $data
     * @return bool|void
     * @throws Exception
     */
    public function save($data)
    {
        $table = $this->getTable('Spreadshop', 'Table');

        //safe unchecked mobile_swipe_menu as '0'
        if(!isset($data["mobile_swipe_menu"])){
            $data["mobile_swipe_menu"] = '0';
        }

        //safe unchecked metadata as '0'
        if(!isset($data["metadata"])){
            $data["metadata"] = '0';
        }

        $table->bind($data);
        $table->store();
    }

    /**
     * Delete a item record
     *
     * @param array $data
     * @return bool|void
     * @throws Exception
     */
    public function delete(&$data)
    {
        $table = $this->getTable('Spreadshop', 'Table');
        $table->bind($data);
        $table->delete();
    }
}
