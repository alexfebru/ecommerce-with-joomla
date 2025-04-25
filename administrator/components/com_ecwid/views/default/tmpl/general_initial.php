<?php
/**
 * @author     Ecwid, Inc http://www.ecwid.com
 * @copyright  (C) 2009 - 2021 Ecwid, Inc.
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 * Contributors:
 * @author     Rick Blalock
 * @license    GNU/GPL
 * and
 * @author     RocketTheme http://www.rockettheme.com
 * @license    http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 *
 */

// Check to ensure this file is included in Joomla!
defined('_JEXEC') or die('Restricted access');

?>

<?php

$is_curl_problem = false;
$error = JFactory::getSession()->get('ecwidOauthError');

if ($error) {

	switch ($error) {
		case 'token_response_object_error':
			$error_message = JText::_('COM_ECWID_ADVANCED_OAUTH_ACCEPT_PERMISSIONS');
			break;

		case 'http_post_problem':
			$is_curl_problem = true;
			$error_message = JText::_('COM_ECWID_ADVANCED_OAUTH_HTTP_POST_PROBLEM');
			break;
		
		case 'request_error':
			$error_message = '';
			break;

		default:
			$error_message = JText::_('COM_ECWID_ADVANCED_OAUTH_DEFAULT_PROBLEM');
			break;
	}

	if( !empty($error_message) ) {
		JFactory::getApplication()->enqueueMessage(
			$error_message,
			'error'
		);
	}

	JFactory::getSession()->set('ecwidOauthError', null);
}



$steps = (!$is_curl_problem) ? 2 : 3;

?>

<div id="j-main-container" class="wrap span8">

<form class="pure-form ecwid-settings ec-settings-v<?php echo JVersion::MAJOR_VERSION;?> general-settings"
		  id="adminForm"
		  method="POST"
		  action="<?php echo JRoute::_('index.php?option=com_ecwid'); ?>"
		>
		<input type="hidden" name="task" value="default.saveGeneral" />
		<?php echo JHtml::_('form.token'); ?>
		<fieldset>

			<div class="greeting-box">

				<div class="image-container">
					<img class="greeting-image" src="<?php echo $this->baseurl; ?>/components/com_ecwid/assets/images/store_inprogress.png" width="142" />
				</div>

				<div class="messages-container">
					<div class="main-message">

						<?php echo JText::_('COM_ECWID_INITIAL_THANKS_FOR_CHOOSING_ECWID'); ?>
					</div>
					<div class="secondary-message">
						<?php echo sprintf( JText::_('COM_ECWID_INITIAL_LETS_GET_STARTED'), $steps ); ?>
					</div>
				</div>

			</div>
			<hr />


			<ol>
				<li>
					<h4><?php echo JText::_('COM_ECWID_INITIAL_REGISTER_AT_ECWID'); ?></h4>
					<div>
						<?php echo JText::_('COM_ECWID_INITIAL_REGISTER_AT_ECWID_NOTE'); ?>
					</div>
					<div class="ecwid-account-buttons">
						<a class="pure-button pure-button-secondary" target="_blank" href="<?php echo $this->getRegisterLink(); ?>">
							<?php echo JText::_('COM_ECWID_INITIAL_CREATE_NEW_ACCOUNT'); ?>
						</a>
					</div>
					<div class="note">
						<?php echo JText::sprintf('COM_ECWID_INITIAL_SIGN_UP_NOTE', 'href="http://www.ecwid.com/terms-of-service" target="_blank"',
			'href="https://www.ecwid.com/privacy-policy" target="_blank"'); ?>
					</div>
				</li>

				<?php if( !$is_curl_problem ) { ?>
				<li>
					<h4><?php echo JText::_('COM_ECWID_INITIAL_CONNECT'); ?></h4>
					<div>
						<?php echo JText::_('COM_ECWID_INITIAL_CONNECT_NOTE'); ?>
					</div>
					<div class="ecwid-account-buttons">
						<a class="pure-button pure-button-secondary" href="<?php echo JRoute::_('index.php?option=com_ecwid&task=oauth.connect&purpose=connect', false); ?>">
							<?php echo JText::_('COM_ECWID_INITIAL_SIGN_IN'); ?>
						</a>
					</div>

					<div class="note">
						<?php echo JText::sprintf('COM_ECWID_INITIAL_SIGN_UP_LEGAL_NOTE', 'href="http://www.ecwid.com/terms-of-service" target="_blank"',
			'href="https://www.ecwid.com/privacy-policy" target="_blank"'); ?>
					</div>
				</li>
				<?php } ?>


				<?php if( $is_curl_problem ) { ?>
				<li>
					<h4><?php echo JText::_('COM_ECWID_INITIAL_FIND_STORE_ID'); ?></h4>
					<div>
						<?php echo JText::_('COM_ECWID_INITIAL_FIND_STORE_ID_NOTE'); ?>
					</div>
				</li>
				<li>
					<h4>
						<?php echo JText::_('COM_ECWID_INITIAL_ENTER_STORE_ID'); ?>
					</h4>
					<div><label for="ecwid_store_id"><?php echo JText::_('COM_ECWID_INITIAL_STORE_ID_LABEL'); ?>:</label></div>
					<div class="pure-control-group store-id">
						<?php $this->renderElement('storeID'); ?>
						<button type="submit" class="pure-button pure-button-primary">
							<?php echo JText::_('COM_ECWID_INITIAL_SAVE_STORE_ID'); ?>
						</button>
					</div>

					<div class="note">
						<?php echo JText::sprintf('COM_ECWID_INITIAL_SIGN_UP_LEGAL_NOTE', 'href="http://www.ecwid.com/terms-of-service" target="_blank"',
			'href="https://www.ecwid.com/privacy-policy" target="_blank"'); ?>
					</div>
				</li>
				<?php } ?>
			</ol>


		</fieldset>
	</form>
</div>
