<?php

namespace App;


class LoanCalculator
{

    const RATE_MAX_PRECISION = 4;


    public $principal = null;
    public $rate = null;
    public $result = array(
        'monthlyPayment' => 0,
        'totalInterest' => 0,
        'grandTotal' => 0,
    );

    public  $rules = array(
                                'principal' => 'required|numeric',
                                'termLength' => '',
                                'termLengthType' => '',
                                'rate' => ''
                            );


    /**
     * LoanCalculator constructor.
     * @param $principal
     * @param $termLength
     * @param $termLengthType
     * @param $rate
     */
    public function __construct($principal, $termLength, $termLengthType, $rate)
    {

        if (count(func_get_args()) < 4) {
            throw new \InvalidArgumentException("You must supply the principal, term length, term length type and interest rate.");
        }

        $this->principal = $principal;
        $this->termLength = $termLength;
        $this->termLengthType = $termLengthType;
        $this->rate = $rate;
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

        $this->principal = $this->cleanNumber((string) ($this->principal), 2);

        $this->rate = $this->cleanNumber((string) ($this->rate), 4);

        $M = 0;
        $P = $this->principal;
        $i = $this->rate / 100;
        $n = $this->termLength;
        $q = 12;

        if ($this->termLengthType === "months") {
            $n = $n / 12;
            $q = 12;
        }

        $pow = -1 * $n * $q;
        $this->result['monthlyPayment'] = $M = round(($P * $i) / ($q * (1 - pow(1 + ($i / $q), $pow))), 2);
        $this->result['totalInterest'] = $this->calculateTotalInterest($M, $P, $n, $q);
        $this->result['grandTotal'] = $this->calculateGrandTotal($M, $n, $q);
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
        //var M = $scope.data.monthlyPayment;
        //var P = $scope.data.principal;
        //var n = $scope.data.termLength;
        //var q = 12;

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
        //var M = $scope.data.monthlyPayment;
        //var n = $scope.data.termLength;
        //var q = 12;

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
            return float($numberParts[0]+"."+$numberParts[1]);
        }

        //if there's a decimal part and it's greater than zero, parseFloat it to the preferred precision.
        if (count($numberParts) === 2 && strlen($numberParts[1]) > $digits) {
            $error = "You can only specify up to {$digits} decimal places.";
        }

        return $val;

    }

    /**
     * @throws \Exception
     */
    private function validate()
    {


        if(!is_numeric($this->principal)){
            throw new \Exception('You must supply a valid dollar amount for the principal.');
        }

        if(!is_numeric($this->termLength)){
            throw new \Exception('You must supply a valid term length.');
        }

        if(!in_array($this->termLengthType, array('years','months'))){
            throw new \Exception('You must supply a valid term length type.');
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
