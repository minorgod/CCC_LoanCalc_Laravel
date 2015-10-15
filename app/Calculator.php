<?php

namespace App;


abstract class Calculator
{

    //a couple of constants to be used in truncating and/or rounding digits.
    const INTEREST_RATE_MAX_PRECISION = 4;
    const CURRENCY_MAX_DECIMALS = 2;

    //an array of input data
    protected $data = array();

    //an array to hold any errors or warning messages
    protected $errors = array();

    //an array to hold results
    protected $result = array();

    /**
     * @var array of validation rules suitable for use in Laravel's validation lib
     */
    protected $rules = array();


    /**
     * Calculator constructor.
     */
    public function __construct()
    {
    }

    /**
     * @return mixed
     */
    abstract public function calculate();

    /**
     * @param $val
     * @param $precision
     * @param string $fieldname
     * @return mixed
     * @internal param $digits
     */
    private function cleanNumber($val, $precision, $fieldname = '')
    {

        //cast it to a string so we can easily manipulate the format.
        if (!is_string($val)) {
            $val = (string)$val;
        }

        //If we supplied a friendly name for the field we are cleaning, turn that into a string we can use in error messages.
        $fieldstring = "";
        if (!empty($fieldname)) {
            $fieldstring = " in the {$fieldname} field";

        }

        //regex which will (supposedly) validate commas and decimals...
        //^((\d+)|(\d{1,3})(\,\d{3}|)*)(\.\d{2}|)$

        //strip anything other than digits and decimal
        $val = preg_replace('/[^\d.]/', '', $val);

        //split the number on decimal. If it has more than 2 parts, it's invalid.
        $numberParts = explode(".", $val);
        if (count($numberParts) > 2) {
            $this->setError("You have too many decimals{$fieldstring}! We have removed everything after the invalid decimal. Please double-check your input.",
                $fieldname);
            $val = floatval($numberParts[0] . "." . $numberParts[1]);
        }

        //If there's a decimal part and it's greater than zero, truncate it to the preferred precision.
        //and convert it to a float.
        if (count($numberParts) === 2 && strlen($numberParts[1]) > $precision) {
            $this->setError("You can only specify up to {$precision} decimal places{$fieldstring}. We have truncated the number to the proper precision. Please double check your input to be sure it is correct.",
                $fieldname);
            //$result['value'] = floatval($numberParts[0].".".substr($numberParts[1],0,$precision));
            //of course, we could have done this with sprintf too...
            $format = "%.{$precision}f";
            $val = floatval(sprintf($format, $val));
        }

        return $val;
    }


    /**
     * Set the data
     * @param $data
     */
    public function setData($data)
    {
        $data = $this->validate($data);
        $this->data = $data;
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
     * @param null $data
     * @return
     * @throws \Exception
     */
    public function validate($data = null)
    {

        if (empty($data)) {
            $data = $this->data;
        }

        if (empty($data)) {
            throw new \Exception('Calculator data is not set.');
        }


        return $data;

    }

    /**
     * @param $message
     * @param string $name
     */
    public function setError($message, $name = "")
    {
        $this->errors[$name] = $message;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }

}
