/* global localize, jQuery */
const svCalculatorPawnshop = ( args ) => {
	(function ($) {
		const sv_calc_ves   = $('#sv-calculator-ves');   // Укажите примерный вес изделия
		const sv_calc_proba = $('#sv-calculator-proba'); // Выберите пробу

		const sv_calc_result_estimation = $('#sv-calculator-result-estimation'); // Сумма оценки
		const sv_calc_result_period     = $('#sv-calculator-result-period');     // Укажите срок
		const sv_calc_result_loan       = $('#sv-calculator-result-loan');       // Сумма вашего займа
		const sv_calc_result_percent    = $('#sv-calculator-result-percent');    // Процент
		const sv_calc_result_refund     = $('#sv-calculator-result-refund');     // Сумма к возврату

		const sv_calc_period = $('#sv-calculator-period');
		sv_calc_period.slider({
			animate : 'slow',
			range   : 'min',
			min		: 1,
			max		: args.calc_max,
			step    : 1,
			value   : args.calc_default,
			slide   : function(event, ui) {
				let ui_value = ui.value;
				sv_calc_result_period.val( ui_value );

				svCalcInit( sv_calc_ves, 'keyup' );
				svCalcInit( sv_calc_proba, 'change' );
				svCalcInit( sv_calc_result_period, 'keyup' );
				svCalcResult();
			},
		});

		svInputTrim( sv_calc_ves, 'keyup' );
		svInputTrim( sv_calc_result_period, 'keyup' );

		svInputNumber( sv_calc_ves, 'keyup' );
		svInputNumber( sv_calc_result_period, 'keyup' );

		svInputMinMax( sv_calc_ves, 'keyup', 1, 999999 );
		svInputMinMax( sv_calc_result_period, 'keyup', 1, args.calc_max );

		svCalcInit( sv_calc_ves, 'keyup' );
		svCalcInit( sv_calc_proba, 'change' );
		svCalcInit( sv_calc_result_period, 'keyup' );

		function svCalcInit( element, types ) {

			element.on(types, function () {

				let ui_value = sv_calc_result_period.val();

				sv_calc_period.slider({
					animate : 'slow',
					range   : 'min',
					min		: 1,
					max		: args.calc_max,
					step    : 1,
					value   : ui_value,
				});
				svCalcResult();
			});
		}

		/**
		 * Рассчет стоимости (Итого)
		 */
		function svCalcResult() {

			let ui_value = sv_calc_result_period.val();
			let i_ves   = sv_calc_ves.val();
			let i_proba = sv_calc_proba.val();
			let percent = Number( args.calc_result );

			let result_percent = Number( percent * ui_value );
			let proba_ves      = ( i_proba * i_ves );
			let price_100      = ( Number(proba_ves) / 100 );
			let price_percent  = ( price_100 * Number(result_percent) );
			let result         = ( proba_ves + Number(price_percent) );

			sv_calc_result_estimation.text( svPriceSep( proba_ves ) );  // Сумма оценки
			sv_calc_result_loan.text( svPriceSep( proba_ves ) );        // Сумма вашего займа
			sv_calc_result_percent.text( svPriceSep( price_percent ) ); // Процент
			sv_calc_result_refund.text( svPriceSep( result ) );         // Сумма к возврату

			let period_dey = $('#sv-calculator-result-period--dey');
			period_dey.text(svCalcNumWord( ui_value, [
				localize.period_one,
				localize.period_two,
				localize.period_all
			]) );
		}

	})(jQuery);

	/**
	 * Проверка isNaN
	 *
	 * @param result
	 * @returns {number|*}
	 */
	function svIsNaN( result ) {
		if ( isNaN( result ) || result === undefined ) {
			return 0;
		} else {
			return result;
		}
	}

	/**
	 * Проверка на пустоту
	 *
	 * @param element
	 * @param event
	 */
	function svInputTrim( element, event ) {
		element.on( event, function () {
			element.val( this.value.trim() );
		});
	}

	/**
	 * Проверка только цифры
	 *
	 * @param element
	 * @param event
	 */
	function svInputNumber( element, event ) {
		element.on( event, function () {
			if (this.value.match(/[^0-9]/g)) {
				this.value = this.value.replace(/[^0-9]/g, '');
				element.val( this.value.trim() );
			}
		});
	}

	/**
	 * Проверка максимальное и минимальное число
	 *
	 * @param element
	 * @param event
	 * @param min
	 * @param max
	 */
	function svInputMinMax( element, event, min, max ) {
		element.on( event, function (e) {
			let calc_value = this.value;
			if ( Number(calc_value.length) < Number(min) || Number(calc_value) < Number(min) ) {
				element.val( '' );
			}
			if ( Number(calc_value) >= Number(max) ) {
				element.val( max );
			}
		});
	}

	/**
	 * Добавить разделитель тысяч
	 *
	 * @param price число
	 * @param fix Возвращает точное число с фиксированной точкой
	 * @param separator разделитель
	 * @returns {string}
	 * @private
	 *
	 */
	function svPriceSep( price, fix = 0, separator = ' ' ) {
		if ( svIsNaN( price ) ) {
			return price
				.toFixed( fix )
				.toString()
				.replace( /\B(?=(\d{3})+(?!\d))/g, separator );
		}
	}

	/**
	 * Склонение числительных
	 *
	 * @param value
	 * @param words
	 * @returns {*}
	 */
	function svCalcNumWord(value, words){
		value = Math.abs(value) % 100;
		let num = value % 10;
		if(value > 10 && value < 20) return words[2];
		if(num > 1 && num < 5) return words[1];
		if(num === 1) return words[0];
		return words[2];
	}

}