<?php namespace JaycoDesign\Decimal;

/**
 * Class Decimal
 *
 * @package JaycoDesign\Decimal
 */
class Decimal
{
    static protected $scale = 20;

    /**
     * @param int|float $n1
     * @param int|float $n2
     * @param bool      $round
     *
     * @return float
     */
    public static function add($n1, $n2, $round = false)
    {
        $sum = bcadd($n1, $n2, self::$scale);

        return $round ? self::round($sum) : (float)$sum;
    }

    /**
     * @param int|float $n1
     * @param int|float $n2
     * @param bool      $round
     *
     * @return float
     */
    public static function sub($n1, $n2, $round = false)
    {
        $difference = bcsub($n1, $n2, self::$scale);

        return $round ? self::round($difference) : (float)$difference;
    }

    /**
     * @param int|float $n1
     * @param int|float $n2
     * @param bool      $round
     *
     * @return float
     */
    public static function div($n1, $n2, $round = false)
    {
        // Avoid division by Zero
        if ($n2 == 0) {
            return (float)0;
        }

        $quotient = bcdiv($n1, $n2, self::$scale);

        return $round ? self::round($quotient) : (float)$quotient;
    }

    /**
     * @param int|float $n1
     * @param int|float $n2
     * @param bool      $round
     *
     * @return float
     */
    public static function mul($n1, $n2, $round = false)
    {
        $product = bcmul($n1, $n2, self::$scale);

        return $round ? self::round($product) : (float)$product;
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
    public static function markup($cost, $total, $round = false)
    {
        // Avoid division by zero
        if ($cost <= 0) {
            return (float)0;
        }

        $quotient   = self::div($total, $cost);
        $difference = self::sub($quotient, 1);
        $product    = self::mul($difference, 100, $round);
        $markup     = $round ? self::round($product) : $product;

        return (float)$markup;
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
    public static function margin($cost, $charge_out, $round = false)
    {
        // Avoid division by zero
        if ($cost == $charge_out) {
            return (float)0;
        }

        $cost        = self::mul($cost, -1); // make cost be a negative.
        $numerator   = self::add($cost, $charge_out);
        $denominator = max(abs($cost), abs($charge_out));
        $result      = self::div($numerator, $denominator);
        $product     = self::mul($result, 100);
        $margin      = $round ? self::round($product) : $product;

        return (float)$margin;
    }

    /**
     * @param $n1
     * @param $n2
     *
     * @return bool
     */
    public static function compare($n1, $n2)
    {
        $n1 = self::round($n1, 2);
        $n2 = self::round($n2, 2);

        return (bccomp($n1, $n2, self::$scale) === 0);
    }

    /**
     * @param $n1
     * @param $n2
     *
     * @return bool
     */
    public static function greaterThan($n1, $n2)
    {
        $n1 = self::round($n1, 2);
        $n2 = self::round($n2, 2);

        return (bccomp($n1, $n2, self::$scale) > 0);
    }

    /**
     * @param $n1
     * @param $n2
     *
     * @return bool
     */
    public static function lessThan($n1, $n2)
    {
        $n1 = self::round($n1, 2);
        $n2 = self::round($n2, 2);

        return (bccomp($n1, $n2, self::$scale) < 0);
    }

    /**
     * @param            $n1
     * @param            $n2
     * @param bool|false $round
     *
     * @return float
     */
    public static function percentageOf($n1, $n2, $round = false)
    {
        $decimal    = self::div($n1, $n2);
        $percentage = self::mul($decimal, 100);

        return $round ? self::round($percentage) : (float)$percentage;
    }

    /**
     * @param     $n
     * @param int $places
     *
     * @return float
     */
    public static function round($n, $places = 2)
    {
        return (float)round($n, $places);
    }

    /**
     * Trims redundant trailing zeros
     *
     * If the number of non-zero number is less than 2 it returns a number with 2 decimal places.
     *
     * Eg. 1.0000000000000 returns 1.00
     * and 1.2342300000000 returns 1.23423
     *
     * @param  float $n
     *
     * @return float
     */
    public static function trim($n)
    {
        $float         = floatval($n);
        $decimalPlaces = 0;

        // If the number rounded to $decimalPlaces isn't equal to the float val, add another decimal place and try again
        while ($float != round($float, $decimalPlaces)) {
            $decimalPlaces++;
        }

        $decimalPlaces = ($decimalPlaces < 2) ? 2 : $decimalPlaces;

        return number_format($float, $decimalPlaces, ".", "");
    }
}
