<?php 

namespace app\core\exception;


class ForbiddenException extends \Exception
{
    protected $message = 'You are not allowed to access this resource';
    
    protected $code = 403;

}