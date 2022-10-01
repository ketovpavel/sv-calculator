<?php
/**
 * Load Carbon Fields
 *
 * Class SV_Calculator_Carbon_Fields
 */
class SV_Calculator_Carbon_Fields {

	public function __construct() {
		if ( ! class_exists( 'Carbon_Fields\Carbon_Fields' ) ) {
			require SV_CALCULATOR_PLUGIN_DIR . 'vendor/autoload.php';
			Carbon_Fields\Carbon_Fields::boot();
			add_action( 'carbon_fields_register_fields', [ $this, 'register_fields' ], 1 );
		}
	}

	/**
	 * Register Carbon Fields compatibility file.
	 * @link https://docs.carbonfields.net/
	 *
	 * @see register_fields
	 *
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	public function register_fields() {
		require_once SV_CALCULATOR_PLUGIN_DIR . 'vendor/sovetit/function/post-meta.php';
	}
}