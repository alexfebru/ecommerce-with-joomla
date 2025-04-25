<?php
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
JHtml::_('stylesheet', 'administrator/components/com_spreadshop/assets/css/style.css');

JHtml::_('jquery.framework');
JHtml::_('script', 'administrator/components/com_spreadshop/assets/js/shopdetail.js');
JHtml::_('behavior.formvalidator');

if (empty($this->item)) {
    }
else {
?>
<div class="spreadShopAdminWrapper">
    <div class="settingsContainer">
        <div class="left">
            <div class="pluginHeadline"></div>
        </div>
        <div class="right">
            <h1><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_SUBHEADLINE"); ?></h1>
            <form action="<?php echo JRoute::_('index.php?option=com_spreadshop&layout=edit&id=' . (int) $this->item->id); ?>"
                  method="post"
                  name="adminForm"
                  id="adminForm"
                  class="form-validate"
            >

                <div class="edittable">
                    <table class="shopSettingsContainer edittable">
                        <tbody>
                            <tr>
                                <td class="shopSettings__heading" colspan="100%"></td>
                            </tr>

                            <fieldset class="adminform">
                                <tr>
                                    <th colspan="2"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_TABLE_REQUIRED"); ?></th>
                                </tr>
                                <tr>
                                    <td class="shopSettings__divider" colspan="100%"></td>
                                </tr>
                                <?php foreach ($this->form->getFieldset('essentials') as $field): ?>
                                    <tr valign="top">
                                        <th scope="row">
                                            <span class="field-label"><?php echo $field->label; ?></span>
                                        </th>
                                        <td>
                                            <span class="field-input"><?php echo $field->input; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </fieldset>
                            <tr>
                                <th scope="row">&nbsp;</th>
                            </tr>
                            <fieldset>
                                <tr>
                                    <th colspan="2"><?php echo JText::_("COM_SPREADSHOP_SHOPDETAIL_TABLE_ADDITIONAL"); ?></th>
                                </tr>
                                <tr>
                                    <td class="shopSettings__divider" colspan="100%"></td>
                                </tr>
                                <?php foreach ($this->form->getFieldset('additionals') as $field): ?>
                                    <tr valign="top">
                                        <th scope="row">
                                            <span class="field-label"><?php echo $field->label; ?></span>
                                            <span class="field-description"><?php echo $field->description; ?></span>
                                        </th>
                                        <td>
                                            <span class="field-input"><?php echo $field->input; ?></span>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </fieldset>
                        </tbody>
                    </table>
                </div>
                    <div>
                        <a class="btn-secondary"
                           href="https://help.spreadshop.com/hc/en-us/"
                           target="_blank"><?php echo JText::_("COM_SPREADSHOP_SPREADSHOP_LINK_READMORE"); ?> &gt;</a>
                    </div>

                    <input type="submit" onclick="Joomla.submitbutton('shopdetail.save');" class="btn-primary validate"
                        value='<?php echo JText::_("COM_SPREADSHOP_SHOPDETAIL_BUTTON_SAVECHANGES"); ?>' />
                    <a onclick="Joomla.submitbutton('shopdetail.cancel');" class="btn-primary btn-grey" target="_blank">
                        <?php echo JText::_("COM_SPREADSHOP_SHOPDETAIL_BUTTON_CANCEL"); ?></a><br />
                    <a onclick="Joomla.submitbutton('shopdetail.delete');" class="btn-secondary">
                    <span class="icon-trash" ></span>  <?php echo JText::_("COM_SPREADSHOP_SHOPDETAIL_BUTTON_DELETE"); ?></a>
                    <input type="hidden" name="task" value="shopdetail.edit" />
                <?php echo JHtml::_('form.token'); ?>
            </form>
            <?php
            }
            ?>
        </div>
    </div>
</div>
