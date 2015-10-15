<?php

namespace App;

interface LoanCalculatorInterface
{
    /**
     * @param $principal
     * @param $termLength
     * @param $termLengthType
     * @param $rate
     * @return array
     * @throws InvalidArgumentException
     */
    public function calculate();

    /**
     * Set the data
     * @param $data
     */
    public function setData($data);

    /**
     * Get the data
     * @return mixed
     */
    public function getData();

    /**
     * Validate the input data
     * @throws \Exception
     */
    public function validate($data = null);

    /**
     * @param $message
     * @param string $name
     */
    public function setError($message, $name = "");

    /**
     * @return array
     */
    public function getErrors();
}