<?php

namespace App;

class LoanCalculator
{

    public $principal = null;
    public $rate = null;
    public $result = array(
        'monthlyPayment' => 0,
        'totalInterest' => 0,
        'grandTotal' => 0,
    );

    public function calculate($principal, $termLength, $termLengthType, $rate)
    {
        // TODO: write logic here

        $args = func_get_args();

        if (count($args) < 4) {
            throw new InvalidArgumentException("You must supply the principal, term length, term length type and interest rate.");
        }

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

        $this->principal = $this->cleanNumber((string) ($this->principal), 2);

        $this->rate = $this->cleanNumber((string) ($this->rate), 4);

        $M = 0;
        $P = $principal;
        $i = $rate / 100;
        $n = $termLength;
        $q = 12;

        if ($termLengthType === "months") {
            $n = $n / 12;
            $q = 12;
        }

        $pow = -1 * $n * $q;
        $this->result['monthlyPayment'] = $M = round(($P * $i) / ($q * (1 - pow(1 + ($i / $q), $pow))), 2);
        $this->result['totalInterest'] = $this->calculateTotalInterest($M, $P, $n, $q);
        $this->result['grandTotal'] = $this->calculateGrandTotal($M, $n, $q);
        return $this->result;
    }

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

    private function calculateGrandTotal($M, $n, $q)
    {
        //Total amount paid with interest
        //T = Mnq
        //var M = $scope.data.monthlyPayment;
        //var n = $scope.data.termLength;
        //var q = 12;

        return ($M * $n * $q);

    }

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

}
