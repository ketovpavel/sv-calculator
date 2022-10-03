<?php
/**
 * Class SV_Calculator_Main
 */
class SV_Calculator_Main {

	public function __construct() {

		add_action( 'wp_default_scripts', [ $this, 'default_scripts' ], 10, 1 );
		add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_scripts' ] );

		require_once SV_CALCULATOR_PLUGIN_DIR . 'vendor/sovetit/function/register-post-type.php';
	}

	/**
	 * @see enqueue_scripts
	 *
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	public function enqueue_scripts() {

		// Подключаем jQuery
		wp_enqueue_script( 'jquery' );

		$css_pawnshop = self::is_file( '/assets/css/pawnshop.css' );
		if ( $css_pawnshop ) {
			wp_enqueue_style( SV_CALCULATOR_PLUGIN_NAME . '-pawnshop', SV_CALCULATOR_PLUGIN_URL . $css_pawnshop, [], filemtime( SV_CALCULATOR_PLUGIN_DIR . $css_pawnshop ) );
		}

		// Ломбард
		$js_pawnshop = self::is_file( '/assets/js/pawnshop.js' );
		if ( $js_pawnshop ) {
			wp_enqueue_script( SV_CALCULATOR_PLUGIN_NAME . '-pawnshop', SV_CALCULATOR_PLUGIN_URL . $js_pawnshop, [  'jquery-ui' ], filemtime( SV_CALCULATOR_PLUGIN_DIR . $js_pawnshop ), true );
		}

		$css_jquery_ui = self::is_file( '/assets/css/jquery-ui.min.css' );
		if ( $css_jquery_ui ) {
			wp_enqueue_style( 'jquery-ui', SV_CALCULATOR_PLUGIN_URL . $css_jquery_ui, [], filemtime( SV_CALCULATOR_PLUGIN_DIR . $css_jquery_ui ) );
		}

		$js_jquery_ui = self::is_file( '/assets/js/jquery-ui.min.js' );
		if ( $js_jquery_ui ) {
			wp_enqueue_script( 'jquery-ui', SV_CALCULATOR_PLUGIN_URL . $js_jquery_ui, [ 'jquery' ], filemtime( SV_CALCULATOR_PLUGIN_DIR . $js_jquery_ui ), true );
		}

		$js_touch_punch = self::is_file( '/assets/js/touch-punch.min.js' );
		if ( $js_touch_punch ) {
			wp_enqueue_script( 'touch-punch', SV_CALCULATOR_PLUGIN_URL . $js_touch_punch, [ 'jquery-ui' ], filemtime( SV_CALCULATOR_PLUGIN_DIR . $js_touch_punch ), true );
		}

		// Передаем переменные для localize
		wp_localize_script( 'jquery', 'localize', [
			'period_one'        => esc_html__( 'day', SV_CALCULATOR_PLUGIN_DOMAIN ),
			'period_two'        => esc_html__( 'day-two', SV_CALCULATOR_PLUGIN_DOMAIN ),
			'period_all'        => esc_html__( 'days', SV_CALCULATOR_PLUGIN_DOMAIN ),
		] );

	}

	/**
	 * @see is_file
	 *
	 * @param $filename
	 *
	 * @return false|mixed
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	public function is_file( $filename ) {
		if ( is_readable( SV_CALCULATOR_PLUGIN_DIR . $filename ) ) {
			return $filename;
		} else {
			return false;
		}
	}

	/**
	 * Убираем сообщение из консоли браузера:
	 * JQMIGRATE: Migrate is installed, version 3.x.x
	 *
	 * @see default_scripts
	 *
	 * @param $scripts
	 *
	 * @copyright Copyright (c) 2022, SoveTit RU
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 */
	public function default_scripts( $scripts ) {
		if ( ! empty( $scripts->registered['jquery'] ) ) {
			$scripts->registered['jquery']->deps = array_diff( $scripts->registered['jquery']->deps, [ 'jquery-migrate' ] );
		}
	}

	/**
	 * Возврат слов при склонении
	 * Функция возвращает склоненные слова, в зависимости от примененного к ней числа
	 * Например: 5 товаров, 1 товар, 3 товара
	 *
	 * @param $words - массив возможных слов
	 * @param $value - число, к которому необходимо применить склонение
	 *
	 * @return mixed
	 * @see declension
	 *
	 * @copyright Copyright (c) 2022, SoveTit RU
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 */
	public function declension( $words, $value = 1 ) {
		$count = [ 2, 0, 1, 1, 1, 2 ];
		return $words[ (
			$value % 100 > 4 && $value % 100 < 20
		) ? 2 : $count[ ( $value % 10 < 5 ) ? $value % 10 : 5 ] ];
	}

	/**
	 * Добавить разделитель тысяч
	 *
	 * @see format_price
	 *
	 * @param $number
	 *
	 * @return string
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	public function format_price( $number ) {
		return number_format( $number, 0, ',', ' ' );
	}

}