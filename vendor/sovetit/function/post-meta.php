<?php
use Carbon_Fields\Field;
use Carbon_Fields\Container;

Container::make( 'post_meta', 'settings_sv_calc_pawnshop',
	esc_html__( 'Settings', SV_CALCULATOR_PLUGIN_DOMAIN ) )
         ->where( 'post_type', '=', 'sv-calculator' )
         ->add_fields( [

	         Field::make( 'text', 'sv_calc_pawnshop_ves', esc_html__( 'Default weight', SV_CALCULATOR_PLUGIN_DOMAIN ) )
	              ->set_attributes( [
		              'placeholder' => '2',
		              'pattern'     => '[0-9]+',
	              ] )
	              ->set_width( 15 )
	              ->set_required(),

	         Field::make( 'complex', 'sv_calc_pawnshop_proba_complex', '' )
	              ->add_fields( [
		              Field::make( 'text', 'sv_calc_pawnshop_ves', esc_html__( 'Metric value', SV_CALCULATOR_PLUGIN_DOMAIN ) )
		                   ->set_width( 50 )
		                   ->set_required(),

		              Field::make( 'text', 'sv_calc_pawnshop_price', esc_html__( 'Cost', SV_CALCULATOR_PLUGIN_DOMAIN ) )
		                   ->set_width( 50 )
		                   ->set_required()
		                   ->set_help_text( esc_html__( 'In rubles per 1 gram', SV_CALCULATOR_PLUGIN_DOMAIN ) ),
	              ] )->setup_labels( [ 'singular_name' => esc_html__( 'sample', SV_CALCULATOR_PLUGIN_DOMAIN ) ] )
	              ->set_width( 30 )
	              ->set_required(),

	         Field::make( 'select', 'sv_calc_pawnshop_period_max', esc_html__( 'Maximum term', SV_CALCULATOR_PLUGIN_DOMAIN ) )
	              ->set_options( [
		              '30'   => esc_html__( '1 month', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '60'   => esc_html__( '2 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '90'   => esc_html__( '3 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '120'  => esc_html__( '4 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '150'  => esc_html__( '5 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '180'  => esc_html__( '6 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '210'  => esc_html__( '7 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '240'  => esc_html__( '8 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '270'  => esc_html__( '9 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '300'  => esc_html__( '10 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '330'  => esc_html__( '11 months', SV_CALCULATOR_PLUGIN_DOMAIN ),
		              '365'  => esc_html__( '1 year', SV_CALCULATOR_PLUGIN_DOMAIN ),
	              ] )
	              ->set_width( 15 )
	              ->set_required(),

	         Field::make( 'text', 'sv_calc_pawnshop_period', esc_html__( 'Default deadline', SV_CALCULATOR_PLUGIN_DOMAIN ) )
	              ->set_attributes( [
		              'placeholder' => '30',
		              'pattern'     => '[0-9]+',
	              ] )
	              ->set_width( 15 )
	              ->set_required(),

	         Field::make( 'text', 'sv_calc_pawnshop_result', esc_html__( 'Interest rate', SV_CALCULATOR_PLUGIN_DOMAIN ) )
	              ->set_attributes( [
		              'placeholder' => '0.364',
	              ] )
	              ->set_width( 15 )
	              ->set_required(),

	         Field::make( 'textarea', 'sv_calc_pawnshop_note', esc_html__( 'Note', SV_CALCULATOR_PLUGIN_DOMAIN ) )
	              ->set_width( 100 )
	              ->set_required(),
         ] )->set_context( 'advanced' );

