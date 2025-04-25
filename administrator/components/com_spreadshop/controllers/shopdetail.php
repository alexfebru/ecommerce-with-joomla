<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * SpreadShop admin component controller
 *
 * @since  1.0.1
 */

class SpreadShopControllerShopDetail extends JControllerForm
{
    public function __construct($config = array())
    {
        parent::__construct($config);
    }

    protected function allowEdit($data = array(), $key = 'id')
    {
        return true;
    }

    protected function allowAdd($data = array(), $key = 'id')
    {
        return true;
    }

    protected function allowDelete($data = array(), $key = 'id')
    {
        return true;
    }
    /**
     * Save data and return to the default list view
     *
     * @return bool|void
     * @throws Exception
     */

    public function save($key = null, $urlVar = null)
    {
        $input = JFactory::getApplication()->input;
        $data = $input->get('jform', array(), 'array');
        $model = $this->getModel();
        $model->save($data);
        $this->setRedirect(JRoute::_('index.php?option=com_spreadshop', false), JText::_("COM_SPREADSHOP_SHOPDETAIL_MESSAGE_SAVE"));
    }

    /**
     * Cancel editing
     * @return bool|void
     */
    public function cancel($key = null)
    {
        $this->setRedirect(JRoute::_('index.php?option=com_spreadshop', false), JText::_("COM_SPREADSHOP_SHOPDETAIL_MESSAGE_CANCEL"));
    }

    /**
     * Save data and return to the default list view
     *
     * @return bool|void
     * @throws Exception
     */
    public function delete()
    {
        $input = JFactory::getApplication()->input;
        $data = $input->get('jform', array(), 'array');
        $model = $this->getModel();
        $model->delete($data);
        $this->setRedirect(JRoute::_('index.php?option=com_spreadshop', false), JText::_("COM_SPREADSHOP_SHOPDETAIL_MESSAGE_DELETE"));
    }

}
