<?php

namespace Etronic\PhpMvcCore;
class Session
{
    protected const FLASH_KEY = 'flash_messages';
    public function __construct()
    {
        session_start();
        $flash_messages=$_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flash_messages as $key=>&$flash_message)
        {
            // Mark the flash message as removed
            $flash_message['remove'] = true;

        }

        $_SESSION[self::FLASH_KEY]=$flash_messages;  
      
    }

    public function setFlash($key, $message)
    {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value' => $message,
            'remove' => false
        ];

        


    }

    public function getFlash($key){


        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
       
       

    }

    public function __destruct()
    {
        $flash_messages=$_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flash_messages as $key=>&$flash_message)
        {
            // Mark the flash message as removed
        
            if($flash_message['remove'])
            {
                unset($_SESSION['flash_messages'][$key]);
            }

        }


        
    }

    public function set($key,$value)
    {
        $_SESSION[$key] = $value;

    }

    public function get($key)
    {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key)
    {
        unset($_SESSION[$key]);
    }


}