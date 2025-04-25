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
 */

// Check to ensure this file is included in Joomla!
defined( '_JEXEC' ) or die( 'Restricted access' );

class EcwidProductApi {
	var $store_id = '';

	var $error = '';

	var $error_code = '';

	var $ECWID_PRODUCT_API_V3_ENDPOINT = 'https://app.ecwid.com/api/v3';

	function __construct( $store_id ) {
		$this->store_id = intval( $store_id );
	}

	function EcwidProductApi( $store_id ) {
		if ( version_compare( PHP_VERSION, '5.0.0', '<' ) ) {
			$this->__construct( $store_id );
		}
	}

	function internal_parse_json( $json ) {
		return json_decode( $json, true );
	}

	function internal_fetch_url_libcurl( $url ) {
		$timeout = 90;
		if ( ! function_exists( 'curl_init' ) ) {
			return array(
				'code' => '0',
				'data' => "The libcurl module isn't installed on your server. Please contact  your hosting or server administrator to have it installed.",
			);
		}
		// $headers[] = "Content-Type: application/x-www-form-urlencoded";
		$headers[] = 'Content-Type: text/json';
		$ch        = curl_init();

		curl_setopt( $ch, CURLOPT_URL, $url );
		curl_setopt( $ch, CURLOPT_HEADER, 0 );
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt( $ch, CURLOPT_HTTPGET, 1 );
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

		$body  = curl_exec( $ch );
		$errno = curl_errno( $ch );
		$error = curl_error( $ch );

		$httpcode = curl_getinfo( $ch, CURLINFO_HTTP_CODE );
		$result   = array();
		if ( $error ) {
			return array(
				'code' => '0',
				'data' => "libcurl error($errno): $error",
			);
		}

		return array(
			'code' => $httpcode,
			'data' => $body,
		);
	}

	function process_request( $url ) {

		$result = $this->internal_fetch_url_libcurl( $url );

		if ( $result['code'] == 200 ) {
			$this->error      = '';
			$this->error_code = '';
			$json             = $result['data'];
			return $this->internal_parse_json( $json );
		} else {
			$this->error      = $result['data'];
			$this->error_code = $result['code'];
			return false;
		}
	}

	public function build_request_url( $endpoint, $params = array() ) {

		$params['token'] = Ecwid::getApiV3()->getToken();

		$url = $this->ECWID_PRODUCT_API_V3_ENDPOINT . '/' . $this->store_id . '/' . $endpoint;

		if ( in_array( $endpoint, array( 'categories', 'products' ) ) && isset( $params['id'] ) ) {
			$url .= '/' . $params['id'];
			unset( $params['id'] );
		}

		$url .= '?' . http_build_query( $params );

		return $url;
	}

	function get_all_categories() {
		$api_url = $this->build_request_url( 'categories' );
		$result  = $this->process_request( $api_url );

		$categories = array();
		if ( ! empty( $result['items'] ) ) {
			$categories = $result['items'];
		}

		return $categories;
	}

	function get_subcategories_by_id( $parent_category_id = 0 ) {
		$parent_category_id = intval( $parent_category_id );

		$api_url = $this->build_request_url(
			'categories',
			array(
				'parent'         => $parent_category_id,
				'responseFields' => 'count,items(name,url)',
			)
		);
		$result  = $this->process_request( $api_url );

		$categories = array();
		if ( ! empty( $result['items'] ) ) {
			$categories = $result['items'];
		}

		return $categories;
	}

	function get_all_products() {
		$api_url = $this->build_request_url( 'products' );
		$result  = $this->process_request( $api_url );

		$products = array();
		if ( ! empty( $result['items'] ) ) {
			$products = $result['items'];
		}

		return $products;
	}

	function get_products_by_category_id( $category_id = 0 ) {
		$category_id = intval( $category_id );

		$api_url = $this->build_request_url(
			'products',
			array(
				'category'       => $category_id,
				'responseFields' => 'count,items(price,name,url)',
			)
		);
		$result  = $this->process_request( $api_url );

		$products = array();
		if ( ! empty( $result['items'] ) ) {
			$products = $result['items'];
		}

		return $products;
	}

	function get_product( $product_id ) {
		static $cached;

		$product_id = intval( $product_id );

		if ( isset( $cached[ $product_id ] ) ) {
			return $cached[ $product_id ];
		}

		$api_url               = $this->build_request_url( 'products', array( 'id' => $product_id ) );
		$cached[ $product_id ] = $this->process_request( $api_url );

		return $cached[ $product_id ];
	}

	function get_category( $category_id ) {
		static $cached = array();

		$category_id = intval( $category_id );

		if ( isset( $cached[ $category_id ] ) ) {
			return $cached[ $category_id ];
		}

		$api_url                = $this->build_request_url( 'categories', array( 'id' => $category_id ) );
		$cached[ $category_id ] = $this->process_request( $api_url );

		return $cached[ $category_id ];
	}

	function get_profile( $get_from_cache = false ) {
		$profile = JFactory::getSession()->get( 'ecwidStoreProfile-' . $this->store_id );

		if ( $get_from_cache && ! empty( $profile ) ) {
			return $profile;
		}

		$api_url = $this->build_request_url(
			'profile',
			array(
				'responseFields' => 'settings(closed),formatsAndUnits(currency)',
			)
		);
		$profile = $this->process_request( $api_url );

		JFactory::getSession()->set( 'ecwidStoreProfile-' . $this->store_id, $profile );

		return $profile;
	}

	function is_api_enabled() {
		// quick and lightweight request
		$api_url = $this->build_request_url( 'profile' );
		$this->process_request( $api_url );

		if ( $this->error_code === '' ) {
			return true;
		} else {
			return false;
		}
	}
}
