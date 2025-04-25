<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');

/**
 * SpreadShop admin component controller
 *
 * @since  1.0.1
 */

class SpreadShopControllerSpreadShop extends JControllerAdmin
{
    /**
     * Proxy for getModel.
     *
     * @param   string  $name    The model name. Optional.
     * @param   string  $prefix  The class prefix. Optional.
     * @param   array   $config  Configuration array for model. Optional.
     *
     * @return  object  The model.
     *
     * @since   1.6
     */
    public function getModel($name = 'SpreadShop', $prefix = 'SpreadShopModel', $config = array('ignore_request' => true))
    {
        $model = parent::getModel($name, $prefix, $config);
        return $model;
    }
}