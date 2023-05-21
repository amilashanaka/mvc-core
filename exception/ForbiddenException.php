<?php 

namespace etronic\phpmvc\exception;


class ForbiddenException extends \Exception
{
    protected $message = 'You are not allowed to access this resource';
    
    protected $code = 403;

}