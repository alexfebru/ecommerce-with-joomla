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

class EcwidCatalog
{
	protected  $store_id = 0;
	protected $store_base_url = '';
	protected $ecwid_api = null;
	protected $with_microdata = true;
	
	function __construct($store_id, $store_base_url, $with_microdata = true)
	{
		$this->store_id = intval($store_id);
		$this->store_base_url = $store_base_url;	
		$this->ecwid_api = new EcwidProductApi($this->store_id);
		$this->with_microdata = $with_microdata;
	}
	

	function EcwidCatalog($store_id)
	{
		if(version_compare(PHP_VERSION, "5.0.0", "<"))
			$this->__construct($store_id);
	}

	function get_product($id)
	{
		$product = $this->ecwid_api->get_product($id);

		$profile = $this->ecwid_api->get_profile(true);
		$currency = $profile['formatsAndUnits']['currency'];

		$return = '';
		
		if (is_array($product)) 
		{
		
			$md_type = $md_name = $md_sku = '';
			if ($this->with_microdata) {
				$md_type =  ' itemscope itemtype="http://schema.org/Product"';
				$md_name =  ' itemprop="name"';
				$md_sku  = '  itemprop="sku"';
				$md_image = ' itemprop="image"';
				$md_offer = '  itemprop="offers" itemscope itemtype="http://schema.org/Offer"';
				$md_price = ' itemprop="price"';
				$md_currency = ' itemprop="priceCurrency"';
			}
			
			$return = '<div' . $md_type . '>';
			$return .= '<h2 class="ecwid_catalog_product_name"' . $md_name . '>' . htmlspecialchars($product["name"]) . '</h2>';
			$return .= '<p class="ecwid_catalog_product_sku"' . $md_sku . '>' . htmlspecialchars($product["sku"]) . '</p>';
			
			if (!empty($product["thumbnailUrl"])) 
			{
				$return .= sprintf(
					'<div class="ecwid_catalog_product_image"><img%s src="%s" alt="%s" /></div>',
					$md_image,
					htmlspecialchars($product['thumbnailUrl']),
					htmlspecialchars($product['name'] . ' ' . $product['sku'])
				);
			}
			
			if (array_key_exists('categories', $product) && is_array($product["categories"]))
			{
				foreach ($product["categories"] as $ecwid_category) 
				{
					if( isset($ecwid_category["defaultCategory"]) && $ecwid_category["defaultCategory"] == true)
					{
						$return .= '<div class="ecwid_catalog_product_category">' . htmlspecialchars($ecwid_category['name']) . '</div>';
					}
				}
			}


			$md_offer = $md_price = $md_currency = $md_descr = '';
			if ($this->with_microdata) {
				$md_offer = '  itemprop="offers" itemscope itemtype="http://schema.org/Offer"';
				$md_price = ' itemprop="price"';
				$md_currency = ' itemprop="priceCurrency"';
				$md_descr = ' itemprop="description"';
			}
			
			$return .= '<div class="ecwid_catalog_product_price"' . $md_offer . '>';
			$return .=  'Price : <span' . $md_price . ' content="' . htmlspecialchars($product['price']) . '">' . htmlspecialchars($product["price"]) . '</span>&nbsp;';
			$return .= '<span' . $md_currency . ' content="' . htmlspecialchars($currency) . '">' . htmlspecialchars($currency) . '</span>';

			if ($this->with_microdata && !isset($product['quantity']) || (isset($product['quantity']) && $product['quantity'] > 0))
			{
				$return .= '<link itemprop="availability" href="http://schema.org/InStock" />In stock';
			}

            $return .= '</div>';

            $return .= '<div class="ecwid_catalog_product_description"' . $md_descr . '>'
				. $product['description']
				. '</div>';


            if (is_array($product['attributes']) && !empty($product['attributes'])) {

                foreach ($product['attributes'] as $attribute) {
					$value = htmlspecialchars(trim($attribute['value']));
                    if ($value != '') {
                        $return .= '<div class="ecwid_catalog_product_attributes">' . htmlspecialchars($attribute['name']) . ':';
                        if ($this->with_microdata && isset($attribute['internalName']) && $attribute['internalName'] == 'Brand') {
                            $return .= '<span itemprop="brand">' . $value . '</span>';
                        } else {
                            $return .= $value;
                        }
 						$return .= '</div>';
 					}
 				}
 			}

			if (is_array($product["options"]))
			{
				$allowed_types = array('TEXTFIELD', 'DATE', 'TEXTAREA', 'SELECT', 'RADIO', 'CHECKBOX');
				foreach($product["options"] as $product_options)
				{
					if (in_array($product_options['type'], $allowed_types)) {
						$return .= '<div class="ecwid_catalog_product_options"><span>'
							. htmlspecialchars($product_options["name"])
							. '</span></div>';
					} else {
						continue;
					}
					if($product_options["type"] == "TEXTFIELD" || $product_options["type"] == "DATE")
					{
						$return .='<input type="text" size="40" name="'. htmlspecialchars($product_options["name"]) . '">';
					}
				   	if($product_options["type"] == "TEXTAREA")
					{
					 	$return .='<textarea name="' . htmlspecialchars($product_options["name"]) . '"></textarea>';
					}
					if ($product_options["type"] == "SELECT")
					{
						$return .= '<select name="' . htmlspecialchars($product_options["name"]) . '">';
						foreach ($product_options["choices"] as $options_param) 
						{ 
							$return .= sprintf(
								'<option value="%s">%s (%s)</option>',
								htmlspecialchars($options_param['text']),
								htmlspecialchars($options_param['text']),
								htmlspecialchars($options_param['priceModifier'])
							);
						}
						$return .= '</select>';
					}
					if($product_options["type"] == "RADIO")
					{
						foreach ($product_options["choices"] as $options_param) 
						{
							$return .= sprintf(
								'<input type="radio" name="%s" value="%s" />%s (%s)<br />',
								htmlspecialchars($product_options['name']),
								htmlspecialchars($options_param['text']),
								htmlspecialchars($options_param['text']),
								htmlspecialchars($options_param['priceModifier'])
							);
						}
					}
					if($product_options["type"] == "CHECKBOX")
					{
						foreach ($product_options["choices"] as $options_param)
						{
							$return .= sprintf(
								'<input type="checkbox" name="%s" value="%s" />%s (%s)<br />',
								htmlspecialchars($product_options['name']),
								htmlspecialchars($options_param['text']),
								htmlspecialchars($options_param['text']),
								htmlspecialchars($options_param['priceModifier'])
						 	);
					 	}
					}
				}
			}				
						
			if (is_array($product["galleryImages"])) 
			{
				foreach ($product["galleryImages"] as $galleryimage) 
				{
					if (empty($galleryimage["alt"]))  $galleryimage["alt"] = htmlspecialchars($product["name"]);
					$return .= sprintf(
						'<img src="%s" alt="%s" title="%s" /><br />',
						htmlspecialchars($galleryimage['url']),
						htmlspecialchars($galleryimage['alt']),
						htmlspecialchars($galleryimage['alt'])
					);
				}
			}

			$return .= "</div>" . PHP_EOL;
		}

		return $return;
	}

	function get_category($id)
	{
		$categories = $this->ecwid_api->get_subcategories_by_id($id);
		$products = $this->ecwid_api->get_products_by_category_id($id);
		$profile = $this->ecwid_api->get_profile(true);
		$currency = $profile['formatsAndUnits']['currency'];

        $return = '';

		if ($id > 0) {
			$category = $this->ecwid_api->get_category($id);

			$return .= '<h2>' . htmlspecialchars($category['name']) . '</h2>';
			$return .= '<div>' . $category['description'] . '</div>';
		}

		if (is_array($categories)) 
		{
			foreach ($categories as $category) 
			{
				$category_url = $this->build_url($category["url"]);
				$category_name = $category["name"];
				$return .= sprintf(
					'<div class="ecwid_catalog_category_name"><a href="%s">%s</a></div>' . PHP_EOL,
					htmlspecialchars($category_url . '&offset=0&sort=nameAsc'),
					htmlspecialchars($category_name)
				);
			}
		}

		if (is_array($products)) 
		{
			foreach ($products as $product) 
			{
				$product_url = $this->build_url($product["url"]);
				$product_name = $product["name"];
				$product_price = $product["price"] . " " . $currency;
				$return .= "<div>";
				$return .= "<span class='ecwid_product_name'><a href='" . htmlspecialchars($product_url) . "'>" . htmlspecialchars($product_name) . "</a></span>";
				$return .= "&nbsp;&nbsp;<span class='ecwid_product_price'>" . htmlspecialchars($product_price) . "</span>";
				$return .= "</div>" . PHP_EOL;
			}
		}

		return $return;
	}

	function build_url($url_from_ecwid)
	{
		if (preg_match('/(.*)(#!)(.*)/', $url_from_ecwid, $matches))
			return $this->store_base_url . $matches[2] . $matches[3]; 
		else
			return '';
	}
}
