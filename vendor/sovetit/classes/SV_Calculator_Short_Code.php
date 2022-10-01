<?php
/**
 * Class SV_Calculator_Short_Code
 */
class SV_Calculator_Short_Code {

	public function __construct() {

		if ( ! is_admin() ) {
			add_shortcode( 'sv-calculator', [ $this, 'get_short_code' ] );
		}

		add_filter( 'manage_sv-calculator_posts_columns', [ $this, 'manage_posts_columns' ], 4, 1 );
		add_filter( 'manage_sv-calculator_posts_custom_column', [ $this, 'manage_custom_column' ], 5, 2 );
	}

	/**
	 * Обработчик шорт-кода
	 *
	 * @see get_short_code
	 *
	 * @param $args
	 *
	 * @return false|string
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	public function get_short_code( $args ) {

		$type = $args['type'];
		$post = get_post( $args['id'] );

		$post_ID = $post->ID;

		ob_start();
		self::get_template_part( "templates/{$type}", null, $post_ID );
		$template = ob_get_contents();
		ob_end_clean();

		return $template;

	}

	/**
	 * Выведем шорт-код в общий список в админку
	 *
	 * @param $columns
	 *
	 * @return array|string[]
	 * @see manage_posts_columns
	 *
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	public function manage_posts_columns( $columns ) {
		$num = 2; // после какой по счету колонки вставлять
		$new_columns = [
			'short_code' => 'Шорт-код',
		];

		return array_slice( $columns, 0, $num ) + $new_columns + array_slice( $columns, $num );
	}

	/**
	 * Возможность скопировать шорт-код в буфер
	 *
	 * @param $colname
	 * @param $post_ID
	 *
	 * @see manage_custom_column
	 *
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 * @copyright Copyright (c) 2022, SoveTit RU
	 */
	public function manage_custom_column( $colname, $post_ID ) {
		if ( $colname === 'short_code' ) {
			echo "<input type='text' onfocus='this.select();' readonly='readonly' value='[sv-calculator id=\"$post_ID\" type=\"pawnshop\"]' class='large-text code'>";
		}
	}

	/**
	 * Загрузить файл шаблона из каталога плагина
	 * работает точно так же как из каталога темы
	 *
	 * @param $slug
	 * @param $name
	 * @param $args
	 *
	 * @see get_template_part
	 *
	 * @copyright Copyright (c) 2022, SoveTit RU
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 */
	public function get_template_part( $slug, $name = null, $args = [] ) {

		do_action( "get_template_part_{$slug}", $slug, $name );

		$templates = [];
		if ( isset( $name ) ) {
			$templates[] = "{$slug}-{$name}.php";
		}

		$templates[] = "{$slug}.php";

		do_action( 'get_template_part', $slug, $name, $templates, $args );

		self::get_template_path( $templates, true, false, $args );

	}

	/**
	 * Расширение locate_template из WP Core
	 *
	 * @param $template_names
	 * @param $load
	 * @param $require_once
	 * @param $args
	 *
	 * @return string
	 * @see get_template_path
	 *
	 * @copyright Copyright (c) 2022, SoveTit RU
	 * @author Pavel Ketov <pavel@sovetit.ru>
	 */
	public function get_template_path( $template_names, $load = false, $require_once = true, $args = [] ) {
		$located = '';
		foreach ( (array) $template_names as $template_name ) {
			if ( ! $template_name ) {
				continue;
			}

			if ( file_exists( SV_CALCULATOR_PLUGIN_DIR . $template_name ) ) {
				$located = SV_CALCULATOR_PLUGIN_DIR . $template_name;
				break;
			}
		}

		if ( $load && '' != $located ) {
			load_template( $located, $require_once, $args );
		}

		return $located;
	}

}