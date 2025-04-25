<?php

defined('_JEXEC') or die('Restricted access');
/**
 * SpreadShop admin component controller
 *
 * @since  1.0.1
 */
class SpreadShopController extends JControllerLegacy
{
    public function display($cachable = false, $urlparams = false)
    {
        // Set the view
        $vName = $this->input->get('view', 'spreadshop');
        $this->input->set('view', $vName);

        parent::display($cachable, $urlparams);

        return $this;
    }
}