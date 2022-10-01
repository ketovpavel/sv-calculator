<?php /** @var int $args post_ID */
$post_ID = empty( $args ) ? 0 : $args;

$ves = carbon_get_post_meta( $post_ID, 'sv_calc_pawnshop_ves' );                 // Вес по умолчанию
$period_max = carbon_get_post_meta( $post_ID, 'sv_calc_pawnshop_period_max' );   // Максимальный срок
$period_default = carbon_get_post_meta( $post_ID, 'sv_calc_pawnshop_period' );   // Срок по умолчанию

// Процентная ставка
$result = carbon_get_post_meta( $post_ID, 'sv_calc_pawnshop_result' );
$result = str_replace( ',','.',$result );

$note = carbon_get_post_meta( $post_ID, 'sv_calc_pawnshop_note' );               // Примечание

if ( $period_max === 365 ) {
	$period_month = esc_html__( '1 year', SV_CALCULATOR_PLUGIN_DOMAIN );
} else {
	$period_max_d = ( $period_max / 30 );
	$period_month = $period_max_d . ' ' . sv_calculator()->declension( [
			esc_html__( 'month', SV_CALCULATOR_PLUGIN_DOMAIN ),
			esc_html__( 'months', SV_CALCULATOR_PLUGIN_DOMAIN ),
			esc_html__( 'months', SV_CALCULATOR_PLUGIN_DOMAIN )
		], $period_max_d );
}
// Метрическое значение
$proba_complex = carbon_get_post_meta( $post_ID, 'sv_calc_pawnshop_proba_complex' );

$result_a = ( $result * $period_default );
$result_d = ( $ves * $proba_complex[0]['sv_calc_pawnshop_price'] );
$result_t = sv_calculator()->format_price( $result_d, 0, '', ' ' );

$result_p = ( $result_d / 100 );
$price_percent = ( $result_p * $result_a );
$price_percent_t = sv_calculator()->format_price( $price_percent, 0, '', ' ' );
$result_refund = sv_calculator()->format_price( ( $result_d + $price_percent ), 0, '', ' ' );
?>
<div class="sv_calculator sv_calculator__wrapper">
	<div class="sv_calculator__title">
		<?php echo get_the_title( $post_ID ) ?>
	</div>
	<div class="sv_calculator__row">
		<div class="sv_calculator__item">
			<div class="sv_calculator__item--title">
				<?php esc_html_e( 'Specify the approximate weight', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>
			</div>
			<div class="sv_calculator__item--form">
				<span class="sv_calculator__item--input">
					<input type="text" id="sv-calculator-ves" value="<?php echo trim( $ves ) ?>" placeholder="<?php esc_html_e( 'weight', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>">
				</span>
				<span class="sv_calculator__item--unit">
					<?php esc_html_e( 'gr', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>
				</span>
			</div>
		</div>
		<div class="sv_calculator__item">
			<div class="sv_calculator__item--title">
				<?php esc_html_e( 'Choose a trial', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>
			</div>
			<div class="sv_calculator__item--form">
				<span class="sv_calculator__item--select">
				<?php if ( ! empty( $proba_complex ) ) : ?>
					<select id="sv-calculator-proba">
					<?php foreach ( $proba_complex as $item ) : ?>
						<?php $pawnshop_price = trim( $item['sv_calc_pawnshop_price'] ) ?>
						<?php $pawnshop_ves   = trim( $item['sv_calc_pawnshop_ves'] ) ?>
						<option value="<?php echo $pawnshop_price ?>"><?php echo $pawnshop_ves ?> - <?php echo $pawnshop_price ?> <?php esc_html_e( 'rub', SV_CALCULATOR_PLUGIN_DOMAIN ) ?></option>
					<?php endforeach ?>
					</select>
				<?php endif ?>
				</span>
			</div>
		</div>
		<div class="sv_calculator__item">
			<div class="sv_calculator__item--title">
				<?php esc_html_e( 'Assessment amount', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>
			</div>
			<div class="sv_calculator__item--price">
				<span>
					<span id="sv-calculator-result-estimation"><?php echo trim( $result_t ) ?></span> <?php esc_html_e( '₽' ) ?>
				</span>
			</div>
		</div>
		<div class="sv_calculator__item sv_calculator__slider">
			<div class="sv_calculator__item--title">
				<span><?php esc_html_e( 'Specify the deadline', SV_CALCULATOR_PLUGIN_DOMAIN ) ?></span>
				<span class="sv_calculator__slider--input sv_calculator__item--child">
					<input type="text" id="sv-calculator-result-period" value="<?php echo intval( $period_default ) ?>" placeholder="<?php esc_html_e( 'term', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>"> <span id="sv-calculator-result-period--dey"><?php esc_html_e( 'days', SV_CALCULATOR_PLUGIN_DOMAIN ) ?></span>
				</span>
			</div>
			<div class="sv_calculator__item--slider_wrapper">
				<div id="sv-calculator-period" class="sv_calculator__item--slider"></div>
				<div class="sv_calculator__item--period">
					<span><?php esc_html_e( '1 day', SV_CALCULATOR_PLUGIN_DOMAIN ) ?></span>
					<span><?php echo $period_month ?></span>
				</div>
			</div>
		</div>
	</div>
	<div class="sv_calculator__row">
		<div class="sv_calculator__item">
			<div class="sv_calculator__item--title">
				<?php esc_html_e( 'The amount of your loan', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>
			</div>
			<div class="sv_calculator__item--price">
				<span>
					<span id="sv-calculator-result-loan"><?php echo trim( $result_t ) ?></span> <?php esc_html_e( '₽' ) ?>
				</span>
			</div>
		</div>
		<div class="sv_calculator__item">
			<div class="sv_calculator__item--title">
				<?php esc_html_e( 'Percent', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>
			</div>
			<div class="sv_calculator__item--price">
				<span>
					<span id="sv-calculator-result-percent"><?php echo trim( $price_percent_t ) ?></span> <?php esc_html_e( '₽' ) ?>
				</span>
			</div>
		</div>
		<div class="sv_calculator__item">
			<div class="sv_calculator__item--title">
				<?php esc_html_e( 'Amount to be refunded', SV_CALCULATOR_PLUGIN_DOMAIN ) ?>
			</div>
			<div class="sv_calculator__item--price">
				<span>
					<span id="sv-calculator-result-refund"><?php echo trim( $result_refund ) ?></span> <?php esc_html_e( '₽' ) ?>
				</span>
			</div>
		</div>
		<div class="sv_calculator__item">
			<div class="sv_calculator__item--note">
				<?php echo trim( $note ) ?>
			</div>
		</div>
	</div>
</div>
<script>
let period_max      = <?php echo intval($period_max ) ?>;
let period_default  = <?php echo intval( $period_default ) ?>;
let pawnshop_result = <?php echo $result ?>;
</script>