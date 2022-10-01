<?php
/**
 * @see sv_calculator_load_classes
 *
 * @param array $class_name
 *
 * @copyright Copyright (c) 2022, SoveTit RU
 * @author Pavel Ketov <pavel@sovetit.ru>
 */
function sv_calculator_load_classes( array $class_name = [] ) {

	$title = esc_html__( "No class: ", SV_CALCULATOR_PLUGIN_DOMAIN );
	$mess = esc_html__( "Failed to load class: ", SV_CALCULATOR_PLUGIN_DOMAIN );

	foreach ( $class_name as $class ) {
		include SV_CALCULATOR_PLUGIN_DIR . "vendor/sovetit/classes/$class.php";
		if ( class_exists( $class ) ) {
			new $class;
		} else {
			wp_die( $mess . $class, $title . $class );
		}
	}

}

