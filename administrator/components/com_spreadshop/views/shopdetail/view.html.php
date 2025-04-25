<?php
defined('_JEXEC') or die('Restricted access');


/**
 * Spreadshop View
 *
 * @since  0.0.1
 */
class SpreadShopViewShopDetail extends JViewLegacy
{
    /**
     * View form
     *
     * @var form
     */
    protected $form = null;

    /**
     * View Item
     *
     * @var Joomla\CMS\Object\
     */
    protected $item = null;

    /**
     * Display the Spreadshop view
     *
     * @param   string $tpl The name of the template file to parse; automatically searches through the template paths.
     *
     * @return  void
     */
    public function display($tpl = null)
    {
        // Get the Data
        $this->form = $this->get('Form');
        $this->item = $this->get('Item');

        // Set the toolbar
        $this->addToolBar();

        // Display the template
        parent::display($tpl);
    }

    /**
     * Add pagetitle and toolbar
     * @throws Exception
     */
    protected function addToolBar()
    {
        $input = JFactory::getApplication()->input;

        // Hide Joomla Administrator Main menu
        $input->set('hidemainmenu', true);

        $isNew = ($this->item->id == 0);

        if ($isNew) {
            $title = JText::_("COM_SPREADSHOP_SHOPDETAIL_TITLE_NEW");
        } else {
            $title = JText::_("COM_SPREADSHOP_SHOPDETAIL_TITLE_EDIT");
        }

        JToolbarHelper::title($title, 'spreadlogo');
    }
}
