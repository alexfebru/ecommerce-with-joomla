<?php
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
     * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
     * @return  void
     */
    function display($tpl = null)
    {
        // Get data from the model
        $this->items = $this->get('Items');

        // Set the toolbar
        $this->addToolBar();

        // Display the view
        parent::display($tpl);
    }


    /**
     * Add the page title and toolbar.
     *
     * @return  void
     *
     * @since   1.6
     */
    protected function addToolBar()
    {
        JToolbarHelper::title(JText::_("COM_SPREADSHOP_SPREADSHOP_TITLE"), 'spreadlogo');
    }

}