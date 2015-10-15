<?php

namespace App;


class LoanCalculator extends Calculator implements LoanCalculatorInterface
{

    //a couple of constants to be used in truncating and/or rounding digits.
    const INTEREST_RATE_MAX_PRECISION = 4;
    const CURRENCY_MAX_DECIMALS = 2;

    //an array of input data
    protected $data = array();

    //an array to hold any errors or warning messages
    protected $errors = array();

    public $result = array(
        'monthlyPayment' => 0,
        'totalInterest' => 0,
        'grandTotal' => 0,
    );

    /**
     * @var array of validation rules suitable for use in Laravel's validation lib
     */
    public $rules = array(
        'principal' => "required|numeric",
        'termLength' => "required|numeric|integer",
        'termLengthType' => "required|alpha|in:years,months",
        'rate' => "required|numeric"
    );


    /**
     * LoanCalculator constructor.
     * @param Array $input
     */
    public function __construct( $input = array('principal'=>0, 'termLength'=>0, 'termLengthType'=>0, 'rate'=>0) )
    {
        parent::__construct();

        $this->setData($input);
    }

    /**
     * @return array
     */
    public function calculate()
    {

        //The following formulas were taken from
        //http://mathforum.org/dr.math/faq/faq.interest.html

        /*
        Then the monthly payment M is given by:
        P = principal
        i= interest rate as a fraction (eg: 1% = .01)
        n = number of years
        q = number of periods per year (12 for monthly)


        M = Pi/[q(1-[1+(i/q)]^-nq)]

        The amount of principal that can be paid off in n years is
        P = M(1-[1+(i/q)]^-nq)q/i.

        The number of years needed to pay off the loan is
        n = -log(1-[Pi/(Mq)])/(q log[1+(i/q)]).

        The total amount paid by the borrower is Mnq

        total amount of interest paid is
        I = Mnq - P.
         */

        $this->validate();

        $this->data['principal'] = $this->cleanNumber(($this->data['principal']), self::CURRENCY_MAX_DECIMALS, 'principal');
        $this->data['rate'] = $this->cleanNumber(($this->data['rate']), self::INTEREST_RATE_MAX_PRECISION, 'rate');

        $M = 0;
        $P = $this->data['principal'];
        $i = $this->data['rate'] / 100;
        $n = $this->data['termLength'];
        $q = 12;

        if ($this->data['termLengthType'] === "months") {
            $n = $n / 12;
            $q = 12;
        }

        $pow = -1 * $n * $q;
        $this->result['monthlyPayment'] = round(($P * $i) / ($q * (1 - pow(1 + ($i / $q), $pow))), 2);
        $this->result['totalInterest'] = $this->calculateTotalInterest($this->result['monthlyPayment'], $P, $n, $q);
        $this->result['grandTotal'] = $this->calculateGrandTotal($this->result['monthlyPayment'], $n, $q);

        $this->result['errors'] = $this->getErrors();

        return $this->result;
    }

    /**
     * @param $M
     * @param $P
     * @param $n
     * @param $q
     * @return mixed
     */
    private function calculateTotalInterest($M, $P, $n, $q)
    {
        //Total amount of interest paid is
        //I = Mnq - P
        //var $M = monthlyPayment;
        //var $P = principal;
        //var $n = termLength;
        //var $q = 12;

        return round(($M * $n * $q) - $P,2);

    }

    /**
     * @param $M
     * @param $n
     * @param $q
     * @return mixed
     */
    private function calculateGrandTotal($M, $n, $q)
    {
        //Total amount paid with interest
        //T = Mnq
        //var $M = monthlyPayment;
        //var $n = termLength;
        //var $q = 12;

        return round($M * $n * $q, 2);

    }

    /**
     * @param $val
     * @param $precision
     * @param string $fieldname
     * @return mixed
     * @internal param $digits
     */
    private function cleanNumber($val, $precision, $fieldname='')
    {

        //cast it to a string so we can easily manipulate the format.
        if(!is_string($val)){
            $val = (string) $val;
        }

        //If we supplied a friendly name for the field we are cleaning, turn that into a string we can use in error messages.
        $fieldstring = "";
        if(!empty($fieldname)){
            $fieldstring = " in the {$fieldname} field";

        }

        //regex which will (supposedly) validate commas and decimals...
        //^((\d+)|(\d{1,3})(\,\d{3}|)*)(\.\d{2}|)$

        //strip anything other than digits and decimal
        $val = preg_replace('/[^\d.]/', '', $val);

        //split the number on decimal. If it has more than 2 parts, it's invalid.
        $numberParts = explode(".", $val);
        if (count($numberParts) > 2) {
            $this->setError( "You have too many decimals{$fieldstring}! We have removed everything after the invalid decimal. Please double-check your input.", $fieldname);
            $val = floatval($numberParts[0].".".$numberParts[1]);
        }

        //If there's a decimal part and it's greater than zero, truncate it to the preferred precision.
        //and convert it to a float.
        if (count($numberParts) === 2 && strlen($numberParts[1]) > $precision) {
            $this->setError("You can only specify up to {$precision} decimal places{$fieldstring}. We have truncated the number to the proper precision. Please double check your input to be sure it is correct.", $fieldname);
            //$result['value'] = floatval($numberParts[0].".".substr($numberParts[1],0,$precision));
            //of course, we could have done this with sprintf too...
            $format = "%.{$precision}f";
            $val = floatval(sprintf($format, $val));
        }

        return $val;
    }


    /**
     * Validate the input data
     * @throws \Exception
     */
    public function validate($data = null)
    {

        if(empty($data)){
            $data = $this->data;
        }

        if (empty($data['principal']) || !is_numeric($data['principal'])) {
            throw new \Exception('You must supply a valid dollar amount for the principal.');
        }

        if (empty($data['termLength']) || !is_numeric($data['termLength'])) {
            throw new \Exception('You must supply a valid term length.');
        }

        if (empty($data['termLengthType']) || !in_array($data['termLengthType'], array('years', 'months'))) {
            throw new \Exception('You must supply a valid term length type.');
        }

        if (empty($data['rate']) || !is_numeric($data['rate'])) {
            throw new \Exception('You must supply a valid APR.');
        }

        return $data;
    }


}
