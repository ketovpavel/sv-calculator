<?php
/**
 * Регистрируем типы записей
 *
 * @see sv_calculator_register_post_type
 *
 * @author Pavel Ketov <pavel@sovetit.ru>
 * @copyright Copyright (c) 2022, SoveTit RU
 */
function sv_calculator_register_post_type() {
	$labels = [
		'name'               => esc_html__( 'Calculator', SV_CALCULATOR_PLUGIN_DOMAIN ),
		'singular_name'      => esc_html__( 'Calculator', SV_CALCULATOR_PLUGIN_DOMAIN ),
	];
	$args = [
		'labels'             => $labels,
		'public'             => true,
		'publicly_queryable' => false,
		'query_var'          => false,
		'hierarchical'       => false,
		'capability_type'    => 'post',
		'menu_position'      => 20,
		'supports'           => [ 'title' ],
		'menu_icon'          => 'dashicons-calculator'
	];
	register_post_type( 'sv-calculator', $args );
}
add_action( 'init', 'sv_calculator_register_post_type' );