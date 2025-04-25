<?php
/**
 * @package com_spreadshop
 * @version 1.0.1
 * @author Marco hering
 * @copyright (C) 2017 Spreadshirt
 * @license GPLv2 or later http://www.gnu.org/licenses/gpl-2.0.html
 **/

// No direct access to this file
defined('_JEXEC') or die('Restricted access');
?>

<h1>SpreadShop</h1>

<?php echo $this->noConfiguration; ?>

<div id="sprd_shop_<?php echo $this->shopId; ?>"></div>
<script>
    var spread_shop_config = {
        shopName: '<?php echo $this->shopId; ?>',
        prefix: 'https://<?php echo $this->shopId; ?>.myspreadshop.<?php echo $this->platform == 'EU' ? 'net' : 'com' ?>',
        baseId: 'sprd_shop_<?php echo $this->shopId; ?>',
        <?php
            if($this->starttoken !== null) {
                echo "startToken: '" . $this->starttoken . "',\n";
             } ?>
        <?php
            if($this->locale !== ''){
                echo "locale: '" . $this->locale . "',\n";
            } ?>
        updateMetadata: <?php echo $this->metadata; ?>,
        swipeMenu: <?php echo $this->mobileSwipeMenu; ?>,
        integrationProvider: 'Spreadshirt Joomla Plugin v2.5.0'
    };
</script>
<script type="text/javascript"
        src="https://<?php echo $this->shopId; ?>.myspreadshop.<?php echo $this->platform == 'EU' ? 'net' : 'com' ?>/shopfiles/shopclient/shopclient.nocache.js">
</script>
