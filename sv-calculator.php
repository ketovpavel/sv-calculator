<?php
/**
 * Plugin Name: Calculator
 * Description: Calculator for calculating the value of your customers' jewelry. The plugin will be useful for Pawnshops and Jewelry stores.
 * Plugin URI:  https://sovetit.ru/wordpress/plugins/carbon-fields/sv-calculator/
 * Author URI:  https://sovetit.ru/about/
 * Author:      Pavel Ketov
 * Version:     1.2.1
 * Text Domain: sv_calculator
 * Domain Path: /languages
 */
defined( 'ABSPATH' ) || exit;

// Проверяем существование указанной константы
if ( ! defined( 'SV_CALCULATOR_PLUGIN_DIR' ) ) {

	// Domain
	define( 'SV_CALCULATOR_PLUGIN_DOMAIN', 'sv_calculator' );

	// Абсолютный путь к каталогу плагина
	define( 'SV_CALCULATOR_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

	// Имя каталога плагина
	define( 'SV_CALCULATOR_PLUGIN_NAME', basename( SV_CALCULATOR_PLUGIN_DIR ) );

	// URL каталога плагина
	define( 'SV_CALCULATOR_PLUGIN_URL', plugins_url( SV_CALCULATOR_PLUGIN_NAME ) );

	// Версия плагина
	define( 'SV_CALCULATOR_VERSION', '1.2.1' );
}

if ( ! function_exists( 'sv_calculator_setup' ) ) {

	/**
	 * @see sv_calculator_setup
	 *
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	function sv_calculator_setup() {

		load_plugin_textdomain(
			SV_CALCULATOR_PLUGIN_DOMAIN, false,
			dirname( plugin_basename(__FILE__) ) . '/languages'
		);

		require_once SV_CALCULATOR_PLUGIN_DIR . 'vendor/sovetit/function/functions.php';

		sv_calculator_load_classes( [
			'SV_Calculator_Main',
			'SV_Calculator_Short_Code',
			'SV_Calculator_Carbon_Fields',
		] );
	}
}
add_action( 'plugins_loaded', 'sv_calculator_setup' );

/**
 * @see sv_calculator
 *
 * @return SV_Calculator_Main
 * @copyright Copyright (c) 2022, SoveTit RU
 * @author Pavel Ketov <pavel@sovetit.ru>
 */
function sv_calculator() {
	return new SV_Calculator_Main;
}