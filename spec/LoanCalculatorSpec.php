<?php

namespace spec\App;

use PhpSpec\ObjectBehavior;

class LoanCalculatorSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->shouldHaveType('App\LoanCalculator');
	}

	function it_throws_an_exception_when_called_with_no_arguments() {
		//$this->calculate()->shouldEqual(Exception);
		$this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->during('calculate');
	}

	function it_throws_an_ErrorException_when_called_with_1_argument() {
		//$this->calculate()->shouldEqual(Exception);
		$this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->during('calculate', array(0));
	}
	function it_throws_an_ErrorException_when_called_with_2_arguments() {
		//$this->calculate()->shouldEqual(Exception);
		$this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->during('calculate', array(0, 2));
	}

	function it_throws_an_ErrorException_when_called_with_3_arguments() {
		//$this->calculate()->shouldEqual(Exception);
		$this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->during('calculate', array(0, 1, 2));
	}

	function it_returns_an_array_when_called_with_4_arguments() {
		//$this->calculate()->shouldEqual(Exception);
		//$this->shouldHaveType("array")->during('calculate',array(0,1,2,3));
		$this->calculate(1, 1, 1, 1)->shouldBeArray();
	}

	function it_should_return_an_array_with_4_elements() {
		$this->calculate(1, 1, 1, 1)->shouldHaveCount(3);
	}

	function it_should_calculate_monthly_payment_of_83_79_for_1_yearly_term_of_1000_dollars_at_1_perccent() {
		$this->calculate(1000, 1, 'years', '1')->shouldHaveKeyWithValue('monthlyPayment', 83.79);
	}

	function it_should_calculate_monthly_payment_of_1000_83_for_1_monthly_term_of_1000_dollars_at_1_perccent() {
		$this->calculate(1000, 1, 'months', '1')->shouldHaveKeyWithValue('monthlyPayment', 1000.83);
	}
}
