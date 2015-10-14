<?php

namespace spec\App;

use PhpSpec\ObjectBehavior;

class LoanCalculatorSpec extends ObjectBehavior {
	function it_is_initializable() {
		$this->beConstructedWith(1000, 1, 'years', '1');
		$this->shouldHaveType('App\LoanCalculator');
	}

	function it_should_throw_exception_when_missing_constructor_argument() {
		$this->beConstructedWith(1000, 1, 'years');
		$this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->during('__construct');
	}

	function it_should_throw_exception_with_empty_constructor_argument() {
		$this->beConstructedWith(1000, 1, 'years', null);
		$this->shouldThrow('PhpSpec\Exception\Example\ErrorException')->during('__construct');
	}

	function it_should_return_an_array_with_4_elements() {
		$this->beConstructedWith(1000, 1, 'years', '1');
		$this->calculate()->shouldHaveCount(3);
	}

	function it_should_calculate_monthly_payment_of_83_79_for_1_yearly_term_of_1000_dollars_at_1_percent() {
		$this->beConstructedWith(1000, 1, 'years', '1');
		$this->calculate()->shouldHaveKeyWithValue('monthlyPayment', 83.79);
	}

	function it_should_calculate_monthly_payment_of_1000_83_for_1_monthly_term_of_1000_dollars_at_1_percent() {
		$this->beConstructedWith(1000, 1, 'months', '1');
		$this->calculate()->shouldHaveKeyWithValue('monthlyPayment', 1000.83);
	}
}
