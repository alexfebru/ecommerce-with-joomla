<?php
/**
 * @package com_spreadshop
 * @version 2.0.1
 * @author A. Jankovics
 * @copyright (C) 2019 Spreadshirt
 * @license GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 *
 * Default view of the admin component
 *
 **/
defined('_JEXEC') or die('Restricted access');

JHtml::_('stylesheet', 'administrator/components/com_spreadshop/assets/css/style.css');
?>

<form action="<?php echo JRoute::_('index.php?option=com_spreadshop&view=spreadshop.shopdetail'); ?>"
      method="post"
      name="adminForm"
      id="adminForm">

<div class="spreadShopAdminWrapper">
    <div class="settingsContainer">
        <div class="left">
            <div class="pluginHeadline"></div>
        </div>
        <div class="right">
            <h1><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_HEADLINE1"); ?></h1>

            <?php
                if (empty($this->items)) {?>
                    <p>
                        <?php echo JText::_('COM_SPREADSHOP_SPREADSHOP_NOCONFIGURATIONFOUND'); ?>
                    </p>
                    <a href="index.php?option=com_spreadshop&view=shopdetail&layout=edit" class="btn-primary">
                        <?php echo JText::_('COM_SPREADSHOP_SPREADSHOP_BUTTON_CREATENEW'); ?>
                    </a>

                <?php
                }

                else {
                    foreach ($this->items as $i => $shop) {
                        /*
                         * Only one configuration is allowed an may be found! The first.
                         */
                            // Edit-Link
                            $link = JRoute::_('index.php?option=com_spreadshop&task=shopdetail.edit&id=' . $shop->id);
                            ?>
                            <div class="edittable">
                                <table class="shopSettingsContainer editable">
                                    <tbody>
                                    <tr>
                                        <td class="shopSettings__heading" colspan="100%"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_SUBHEADLINE"); ?></td>
                                    </tr>
                                    <tr>
                                        <th scope="row" style="width: 254px"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_TABLE_REQUIRED"); ?></th>
                                    </tr>
                                    <tr>
                                        <td class="shopSettings__divider" colspan="100%"></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_LABEL_SHOPID"); ?></th>
                                        <td><span>
                                            <?php echo $shop->shop_id; ?>
                                        </span></td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_LABEL_PLATFORM"); ?></th>
                                        <td><span> <?php echo $shop->platform; ?></span></td>
                                    </tr>
                                    </tbody>
                                </table>

                                <a href="<?php echo $link; ?>" class="btn-primary" id="spreadShopChangeSettings"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_BUTTON_EDIT"); ?></a>
                            </div>
                            <a class="btn-grey" href="<?php echo JURI::root() . 'index.php?option=com_spreadshop&view=spreadshop&id=' . $shop->id; ?>" target="_blank"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_BUTTON_PREVIEWSHOP"); ?></a>
                            <a class="btn-grey" href="https://partner.spreadshirt.net" target="_blank"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_BUTTON_LOGINATSPREADSHIRT"); ?></a>
                            <div>
                                <a class="btn-secondary"
                                   href="https://help.spreadshop.com/hc/en-us/"
                                   target="_blank"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_LINK_READMORE"); ?> &gt;</a>
                            </div><br/>
                            <?php
                    }
                }
            ?>
        </div>
    </div>
</div>
    <input type="hidden" name="task" value="" />
    <input type="hidden" name="boxchecked" value="0" />
    <?php echo JHtml::_('form.token'); ?>
</form>