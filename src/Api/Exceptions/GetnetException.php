<?php
namespace Getnet\Api\Exceptions;

use Exception;
use Throwable;

class GetnetException extends Exception
{
    private $details;

    public function __construct($message = '', $code = 0, Throwable $previous = null, array $details = [])
    {
        $this->setDetails($details);
        return parent::__construct($message, $code, $previous);
    }

    /**
     * Set the value of details
     *
     * @param $details
     * @return  self
     */
    public function setDetails($details)
    {
        $this->details = $details;

        return $this;
    }
}