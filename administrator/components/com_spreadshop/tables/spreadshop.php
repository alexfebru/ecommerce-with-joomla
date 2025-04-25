<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_spreadshop
 */
// No direct access
defined('_JEXEC') or die('Restricted access');

/**
 * Spreadshop table class
 *
 * @since  0.0.1
 */
class TableSpreadshop extends JTable
{
    /**
     * Constructor
     *
     * @param   JDatabaseDriver  &$db  A database connector object
     */
    function __construct($db)
    {
        parent::__construct('#__spreadshop', 'id', $db);
    }
}
