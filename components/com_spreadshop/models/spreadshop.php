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
 * SpreadShop Model
 *
 * @since  0.0.1
 */
class SpreadShopModelSpreadShop extends JModelItem
{

    /**
     * @var int $uid
     */
    protected $uid = 0;

    /**
     * @var string $shopId
     */
    protected $shopId;

    /**
     * @var string $platform
     */
    protected $platform;

    /**
     * @var string $starttoken
     */
    protected $starttoken;

    /**
     * @var bool $metadata
     */
    protected $metadata;

    /**
     * @var bool $mobileSwipeMenu
     */
    protected $mobileSwipeMenu;

    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * @var JTable $table
     */
    protected $table;

    /**
     * Method to get a table object, load it if necessary.
     *
     * @param   string  $type    The table name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  JTable  A JTable object
     *
     * @since   1.6
     */
    public function getTable($type = 'Spreadshop', $prefix = 'Table', $config = array())
    {
        return JTable::getInstance($type, $prefix, $config);
    }

    /**
     * Get the uid from the default input
     * @return int uid
     * @throws Exception
     */
    public function getUid()
    {
        $jinput = JFactory::getApplication()->input;
        $this->uid = $jinput->get('id', 1,'INT');

        return $this->uid;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getShopId()
    {
        $this->table = $this->getTable('Spreadshop', 'Table');
        $this->table->load($this->getUid());
        $this->shopId = $this->table->get('shop_id', '', 'string');

        return $this->shopId;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getPlatform() {
        $this->table = $this->getTable('Spreadshop', 'Table');
        $this->table->load($this->getUid());
        $this->platform = $this->table->get('platform', 'NA', 'string');

        return $this->platform;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getStarttoken() {

        if(!isset($this->starttoken)){
            $jinput = JFactory::getApplication()->input;
            $this->starttoken  = $jinput->get('starttoken', NULL, 'raw');

            if ($this->starttoken === NULL) {
                $this->table = $this->getTable('Spreadshop', 'Table');
                $this->table->load($this->getUid());
                $startTokenString = $this->table->get('starttoken', NULL, 'string');

                if (!empty($startTokenString)) {
                    $this->starttoken = '&' . $startTokenString;
                }
                else {
                    $this->starttoken = NULL;
                }
            }
        }
        return $this->starttoken;
    }

    /**
     * @return boolean
     * @throws Exception
     */
    public function getMetadata() {
        $this->table = $this->getTable('Spreadshop', 'Table');
        $this->table->load($this->getUid());
        $this->metadata = $this->table->get('metadata');

        return $this->metadata;
    }

    /**
     * @return boolean
     * @throws Exception
     */
    public function getMobileSwipeMenu()
    {
        $this->table = $this->getTable('Spreadshop', 'Table');
        $this->table->load($this->getUid());
        $this->mobileSwipeMenu = $this->table->get('mobile_swipe_menu');

        return $this->mobileSwipeMenu;
    }

    /**
     * @return string
     * @throws Exception
     */
    public function getLocale() {
        $this->table = $this->getTable('Spreadshop', 'Table');
        $this->table->load($this->getUid());
        $this->locale= $this->table->get('locale', '', 'string');

        return $this->locale;
    }

    public function getItem($pk = null) {

    }
}
