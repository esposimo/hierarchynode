<?php


namespace smn\hnp;


use Throwable;

class NodeException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        //error_log(sprintf('[%s] %s', $this->getCode(), $this->getMessage()), E_USER_ERROR);
    }

}