<?php

use Jaycodesign\Decimal\Decimal;
 
class DecimalTest extends PHPUnit_Framework_TestCase {
 
	public function testAddition()
	{
	    $add_result = Decimal::add("4214.45", "3423532.23");
		$this->assertEquals("3427746.68", $add_result);
	}

	public function testSubtraction()
	{
	    $sub_result = Decimal::sub("23532.23", "2342.34");        
	    $this->assertEquals("21189.89", $sub_result);
	}

	public function testMultiplication()
	{
		$mul_result = Decimal::mul("3532.23", "2342.34");
	    $this->assertEquals("8273683.6182", $mul_result);
	}

	  public function testDivision()
	  {        
	    $div_result = Decimal::div("33532.23", "2342.34");                                                

	    $this->assertEquals("14.3156971234", $div_result);
	  }        

	  public function testDivisionByZero()
	  {
	      $this->assertEquals(Decimal::div("324", "0"), "0");
	  }

	  public function test_markup()
	  {
	      $markup = Decimal::markup(30, 42);
	      $this->assertEquals(40, $markup);

	      $markup = Decimal::markup(0, 0);
	      $this->assertEquals(0, $markup);
	  }

	  public function test_margin()
	  {
	      $margin = Decimal::margin(500, 714.29, TRUE);
	      $this->assertEquals(30, $margin);

	      $margin = Decimal::margin(700, 500, TRUE);
	      $this->assertEquals(-28.57, $margin);

	      $margin = Decimal::margin(-3, 5);
	      $this->assertEquals(160, $margin);

	      $margin = Decimal::margin(-8, -5);
	      $this->assertEquals(37.5, $margin);

	      $margin = Decimal::margin(0, 0);
	      $this->assertEquals(0, $margin);
	  }

	  public function test_compare()
	  {   
	      $compare = Decimal::compare(24.32, "24.32");
	      $this->assertTrue($compare);

	      $compare = Decimal::compare(24.32, "25.31");
	      $this->assertFalse($compare);        
	  }

	  public function test_trim()
	  {
	      $trim = Decimal::trim("234.4300000000000");
	      $this->assertEquals($trim, "234.43");

		    $trim = Decimal::trim("234.434378568");
		    $this->assertEquals($trim, "234.434378568");

		    $trim = Decimal::trim("234.0000");
		    $this->assertEquals($trim, "234.00");
	  }

	  public function test_greater_than()
	  {

	      $greater = Decimal::greater_than("35", "34");
	      $this->assertTrue($greater);

	      $greater = Decimal::greater_than("35", "46");
	      $this->assertFalse($greater);

	      $greater = Decimal::greater_than("35", "35");
	      $this->assertFalse($greater);
	  }
 
}