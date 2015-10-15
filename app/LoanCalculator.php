<?php

namespace App;


class LoanCalculator
{

    const RATE_MAX_PRECISION = 4;


    protected $data = array();

    public $principal = null;
    public $rate = null;
    public $result = array(
        'monthlyPayment' => 0,
        'totalInterest' => 0,
        'grandTotal' => 0,
    );

    public $rules = array(
        'principal' => 'required|numeric',
        'termLength' => '',
        'termLengthType' => '',
        'rate' => ''
    );


    /**
     * LoanCalculator constructor.
     * @param Array $input
     */
    public function __construct( $input = array('principal'=>0, 'termLength'=>0, 'termLengthType'=>0, 'rate'=>0) )
    {
        $this->setData($input);
    }

    /**
     * @param $principal
     * @param $termLength
     * @param $termLengthType
     * @param $rate
     * @return array
     * @throws InvalidArgumentException
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

        $principal = $this->cleanNumber((string)($this->data['principal']), 2);

        $rate = $this->cleanNumber((string)($this->data['rate']), 4);

        $M = 0;
        $P = $principal;
        $i = $rate / 100;
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

        return ($M * $n * $q) - $P;

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

        return ($M * $n * $q);

    }

    /**
     * @param $val
     * @param $digits
     * @return mixed
     */
    private function cleanNumber($val, $digits)
    {

        //regex which will validate commas and decimals...
        //^((\d+)|(\d{1,3})(\,\d{3}|)*)(\.\d{2}|)$

        //strip anything other than digits and decimal
        $val = preg_replace("/[^\d.]/", "", $val);

        //split the number on decimal. If it has more than 2 parts, it's invalid.
        $numberParts = explode(".", $val);
        if (count($numberParts) > 2) {
            $error = "You have too many decimals!";
            return float($numberParts[0] + "." + $numberParts[1]);
        }

        //if there's a decimal part and it's greater than zero, parseFloat it to the preferred precision.
        if (count($numberParts) === 2 && strlen($numberParts[1]) > $digits) {
            $error = "You can only specify up to {$digits} decimal places.";
        }

        return $val;

    }


    /**
     * Set the data
     * @param $data
     */
    public function setData($data)
    {
        $this->validate($data);
        $this->data['principal'] = $data['principal'];
        $this->data['termLength'] = $data['termLength'];
        $this->data['termLengthType'] = $data['termLengthType'];
        $this->data['rate'] = $data['rate'];
    }

    /**
     * Get the data
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Validate the input data
     * @throws \Exception
     */
    private function validate($data = null)
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

        /*$data = array(
            'principal' => $this->principal,
            'termLength' => $this->termLength,
            'termLengthType' => $this->termLengthType,
            'rate' => $this->rate
        );
        */


    }

}
