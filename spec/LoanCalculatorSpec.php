<?php

namespace spec\App;

use PhpSpec\ObjectBehavior;

class LoanCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('App\LoanCalculator');
    }

    function it_should_throw_exception_when_missing_constructor_argument()
    {
        $data = array('principal'=>1000, 'termLength'=>1, 'termLengthType'=>'years');
        $this->beConstructedWith( $data );
        $this->shouldThrow('\Exception')->during('__construct');
    }

    function it_should_throw_exception_with_empty_constructor_argument()
    {
        $data = array('principal'=>1000, 'termLength'=>1, 'termLengthType'=>'years', 'rate'=>null);
        $this->beConstructedWith( $data );
        $this->shouldThrow('\Exception')->during('__construct');
    }

    function it_should_throw_exception_with_invalid_argument()
    {
        $data = array('principal'=>'aaaa', 'termLength'=>1, 'termLengthType'=>'years', 'rate'=>'1.0');
        $this->beConstructedWith( $data );
        $this->shouldThrow('\Exception')->during('__construct');
    }


    function it_should_return_an_array_with_4_elements()
    {
        $data = array('principal'=>1000, 'termLength'=>1, 'termLengthType'=>'years', 'rate'=>1.0);
        $this->beConstructedWith( $data );
        $this->calculate()->shouldHaveCount(4);
    }

    function it_should_calculate_monthly_payment_of_83_79_for_1_year_term_of_1000_dollars_at_1_percent()
{
    $data = array('principal'=>1000, 'termLength'=>1, 'termLengthType'=>'years', 'rate'=>1.0);
    $this->beConstructedWith( $data );
    $this->calculate()->shouldHaveKeyWithValue('monthlyPayment', 83.79);
}
    function it_should_calculate_monthly_payment_of_83_79_for_12_month_term_of_1000_dollars_at_1_percent()
    {
        $data = array('principal'=>1000, 'termLength'=>12, 'termLengthType'=>'months', 'rate'=>1.0);
        $this->beConstructedWith( $data );
        $this->calculate()->shouldHaveKeyWithValue('monthlyPayment', 83.79);
    }

    function it_should_calculate_monthly_payment_of_1000_83_for_1_month_term_of_1000_dollars_at_1_percent()
    {
        $data = array('principal'=>1000, 'termLength'=>1, 'termLengthType'=>'months', 'rate'=>1.0);
        $this->beConstructedWith( $data );
        $this->calculate()->shouldHaveKeyWithValue('monthlyPayment', 1000.83);
    }

    function it_should_limit_rate_input_to_4_decimal_places()
    {
        $data = array('principal'=>1000, 'termLength'=>1, 'termLengthType'=>'months', 'rate'=>'1.000056789');
        $this->beConstructedWith( $data );
        $this->calculate()->shouldHaveKeyWithValue('monthlyPayment', 1000.83);
        $this->getErrors()->shouldHaveKeyWithValue('rate', "You can only specify up to 4 decimal places in the rate field. We have truncated the number to the proper precision. Please double check your input to be sure it is correct.");
    }

    function it_should_limit_principal_input_to_2_decimal_places()
    {
        $data = array('principal'=>'1000.003456', 'termLength'=>1, 'termLengthType'=>'months', 'rate'=>'1.000056789');
        $this->beConstructedWith( $data );
        $this->calculate()->shouldHaveKeyWithValue('monthlyPayment', 1000.83);
        $this->getErrors()->shouldHaveKeyWithValue('principal', "You can only specify up to 2 decimal places in the principal field. We have truncated the number to the proper precision. Please double check your input to be sure it is correct.");
    }
}
