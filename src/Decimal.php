<?php namespace JaycoDesign\Decimal;

class Decimal {

	static protected $scale = 20;

	static function add($n1, $n2, $round = FALSE)
	{
		$sum = bcadd($n1, $n2, self::$scale);

		return $round ? self::round($sum) : (float) $sum;
	}

	static function sub($n1, $n2, $round = FALSE)
	{
		$difference = bcsub($n1, $n2, self::$scale);

		return $round ? self::round($difference) : (float) $difference;
	}

	static function div($n1, $n2, $round = FALSE)
	{
		// Avoid division by Zero
		if ($n2 == 0)
		{
			return 0;
		}

		$quotient = bcdiv($n1, $n2, self::$scale);

		return $round ? self::round($quotient) : (float) $quotient;
	}

	static function mul($n1, $n2, $round = FALSE)
	{
		$product = bcmul($n1, $n2, self::$scale);

		return $round ? self::round($product) : (float) $product;
	}

	/**
	 * Works out markup.
	 *
	 * Profit / Cost = Markup
	 * <---------COST:$100---------><---PROFIT:$25--->
	 * Markup = 25%;
	 *
	 * @param int|float $cost
	 * @param int|float $total
	 * @param bool      $round
	 *
	 * @return float
	 */
	static function markup($cost, $total, $round = FALSE)
	{
		// Avoid division by zero
		if ($cost <= 0)
		{
			return (float) 0;
		}

		$quotient   = self::div($total, $cost);
		$difference = self::sub($quotient, 1);
		$product    = self::mul($difference, 100, $round);
		$markup     = $round ? self::round($product) : $product;

		return (float) $markup;
	}

	/**
	 * Works out margin.
	 *
	 * Profit / Total Revenue = Margin
	 * <---------COST:$100---------><---PROFIT:$25--->
	 * Margin = 20%;
	 *
	 * @param int|float $cost
	 * @param int|float $charge_out
	 * @param bool      $round
	 *
	 * @return float
	 */
	static function margin($cost, $charge_out, $round = FALSE)
	{
		// Avoid division by zero
		if ($cost == $charge_out)
		{
			return (float) 0;
		}

		$cost        = self::mul($cost, - 1); // make cost be a negative.
		$numerator   = self::add($cost, $charge_out);
		$denominator = max(abs($cost), abs($charge_out));
		$result      = self::div($numerator, $denominator);
		$product     = self::mul($result, 100);
		$margin      = $round ? self::round($product) : $product;

		return (float) $margin;
	}

	static function compare($n1, $n2)
	{
		$n1 = self::round($n1, 2);
		$n2 = self::round($n2, 2);

		return (bccomp($n1, $n2, self::$scale) === 0);
	}

	static function greater_than($n1, $n2)
	{
		$n1 = self::round($n1, 2);
		$n2 = self::round($n2, 2);

		return (bccomp($n1, $n2, self::$scale) > 0);
	}

	static function less_than($n1, $n2)
	{
		$n1 = self::round($n1, 2);
		$n2 = self::round($n2, 2);

		return (bccomp($n1, $n2, self::$scale) < 0);
	}

	static function percentage_of($n1, $n2, $round = FALSE)
	{
		$decimal    = self::div($n1, $n2);
		$percentage = self::mul($decimal, 100);

		return $round ? self::round($percentage) : (float) $percentage;
	}

	static function round($n, $places = 2)
	{
		return (float) round($n, $places);
	}

	/**
	 * Trims the trailing 0s from the crazy cost numbers
	 * If the number of not 0s is less than 2 it returns a number with 2 decimal places.
	 * Eg. 1.0000000000000 returns 1.00
	 * and 1.2342300000000 returns 1.23423
	 *
	 * @param  float $n
	 *
	 * @return float
	 */
	static function trim($n)
	{
		$float = floatval($n);
		$number_decimals = 0;

		// If the number rounded to $number_decimals isn't equal to the float val, add another decimal place and try again
		while ($float != round($float, $number_decimals))
		{
			$number_decimals++;
		}

		$number_decimals = ($number_decimals < 2) ? 2 : $number_decimals;

		return number_format($float, $number_decimals, ".", "");
	}
}